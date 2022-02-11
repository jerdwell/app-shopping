<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase;

use Illuminate\Support\Facades\Queue;
use LoftonTi\Apiv1\Services\Products\UseCase\SyncFile\ParseEnterprisesUseCase;
use Loftonti\Apiv1\Services\Products\UseCase\SyncFile\ParseProductsUseCase;
use LoftonTi\Apiv1\Services\Products\UseCase\SyncFile\ParseSyncFileUseCase;
use LoftonTi\Apiv1\Services\Products\UseCase\SyncFile\SyncProductsData;
use LoftonTi\Apiv1\Services\Products\UseCase\SyncFile\SyncProductStockUseCase;

class PrepareProductsToSyncDatabaseUseCase
{
  use
    ParseSyncFileUseCase, 
    ParseProductsUseCase,
    ParseEnterprisesUseCase;

  /**
   * @var string
   */
  private 
    $file,
    $file_path;
  /**
   * @var int
   */
  private $branch_id;
  /**
   * @var array
   */
  private $headers, $rows;
  /**
   * @var array
   */
  private $items_sync = [];
  /**
   * @var object
   */
  private $products, $enterprises;

  /**
   * @param int $branch_id
   * @param string $file_name
   */
  public function __construct(int $branch_id, string $file_name) {
    $this->branch_id = $branch_id;
    $this->file = $file_name;
    $this -> file_path = storage_path("/app/private/sync-files/branch/$this->branch_id/$this->file");
    try {
      $this -> processSync();
    } catch (\Throwable $th) {
      $this -> thrownNotification($th -> getMessage());
    }
  }

  private function processSync(): void
  {
    try {
      $this -> parseFile();
      $this -> parseProducts();
      $this -> parseEnterprises();
      $this -> prepareData();
      $sync_products = new SyncProductsData($this -> items_sync);
      $sync_products = $sync_products();
      $sync_stock = new SyncProductStockUseCase($this -> items_sync);
      $sync_stock = $sync_stock();
      $this -> sendNotification($sync_stock, $sync_products);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * prepare array data
   * @method
   */
  private function prepareData():void
  {
    try {
      $errors = '';
      $r = 0;
      foreach ($this -> rows as $row) {
        $r ++;
        try {
          $erso_code = str_replace('@', '', $row[0]);
          $product_id = $erso_code;
          $product_id = $this -> products[$erso_code];
          if($row[11] == 'Precio público' && $product_id){
            $item = [
              'id' => $product_id,
              'branch_id' => $this -> branch_id,
              'erso_code' => $erso_code,
              'enterprise_id' => $this -> enterprises[$row[12]],
              'product_status' => $row[9] == 'A' ? true : false,
              'stock' => $row[5] ? $row[5] : 0
            ];
            if($row[10]) $item['customer_price'] = number_format($row[10], 2, '.', '');
            if($row[10]) $item['public_price'] = number_format($row[10] * 1.16, 2, '.', '');
            if($row[6]) $item['product_cover'] = "/products/{$row[6]}.jpg";
            array_push($this -> items_sync, $item);
          }
        } catch (\Throwable $th) {
          $errors .= "<li>Error: " . $th->getMessage() . " en la línea " . ($r + 1). "</li>";
        }
      }
      if(strlen($errors) > 0) $this -> thrownNotification($errors);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Send notification after update records
   * @method
   */
  public function sendNotification($sync_stock, $sync_products)
  {
    Queue::push('LoftonTi\Apiv1\Services\Products\Jobs\SyncSuccessNotification', [
      'sync_stock' => $sync_stock,
      'sync_products' => $sync_products,
      'file_path' => $this -> file_path,
      'file_name' => $this -> file
    ]);
  }

  /**
   * Send throw notification if has herrors
   * @method
   */
  public function thrownNotification($errors)
  {
    Queue::push('LoftonTi\Apiv1\Services\Products\Jobs\SyncThrowNotificationJob', [
      'errors' => $errors,
      'file_path' => $this -> file_path,
      'file_name' => $this -> file
    ]);
  }
  
}
