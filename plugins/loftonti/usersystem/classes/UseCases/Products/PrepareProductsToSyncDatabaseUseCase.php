<?php

namespace LoftonTi\Usersystem\Classes\UseCases\Products;

use Illuminate\Support\Facades\Mail;
use Loftonti\Erso\Models\Enterprises;
use Loftonti\Erso\Models\Products;
use LoftonTi\UserSystem\Classes\UseCases\Products\SyncProductsData;

class PrepareProductsToSyncDatabaseUseCase
{

  /**
   * @var string
   */
  private $file;
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

  public function fire($job, $data) {
    try {
      $this->branch_id = $data['branch_id'];
      $this->file = $data['file_name'];
      $this -> processSync();
      $this -> deleteFile();
      $job ->delete();
    } catch (\Throwable $th) {
      $this -> sendTrowNotification($th -> getMessage());
      $this -> deleteFile();
      $job ->delete();
    }
  }

  private function processSync(): void
  {
    try {
      $this -> parseFile();
      $this -> getAllProducts();
      $this -> getAllEnterprises();
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
   * Parse file and set rows and headers
   * @method
   */
  private function parseFile():void
  {
    try {
      $path = storage_path("/app/private/sync-files/branch/$this->branch_id/$this->file");
      $file = fopen($path, 'r');
      $rows = array();
      while (($r = fgetcsv($file, 1000, ",")) !== false) {
        $rows[] = $r;
      }
      fclose($file);
      $this -> headers = $rows[0];
      $this -> validHeaders();
      array_shift($rows);
      $this -> rows = $rows;
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
          $errors .= "<li>Error: " . $th->getMessage() . " en la línea $r</li>";
        }
      }
      if(strlen($errors) > 0) $this -> sendTrowNotification($errors);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Get all products from database
   *  @method 
   */
  private function getAllProducts(): void
  {
    try {
      $products = Products::select('erso_code', 'id')
        ->get();
      foreach ($products as $product) {
        $this -> products[$product -> erso_code] = $product -> id;
      }
      unset($products);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Get all enterprises from database
   *  @method 
   */
  public function getAllEnterprises()
  {
    try {
      $enterprises = Enterprises::select('id', 'rfc')
        -> get();
      foreach ($enterprises as $enterprise) {
        $this -> enterprises[$enterprise -> rfc] = $enterprise -> id;
      }
      unset($enterprises);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Valid if headers and data are in place assigned
   * @method
   */
  public function validHeaders(): void
  {
    try {
      $headers = [
        "CVE_ART",
        "DESCR",
        "LIN_PROD",
        "CON_SERIE",
        "CTRL_ALM",
        "EXIST",
        "CVE_IMAGEN",
        "CVE_PRODSERV",
        "CVE_UNIDAD",
        "STATUS",
        "PRECIO",
        "DESCRIPCION",
        "RFC"
      ];
      for ($i=0; $i < count($this -> headers); $i++) { 
        if($this -> headers[$i] != $headers[$i]) throw new \Exception("Las cabeceras no coinciden con el órden establecido.");
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Delete file storage after update records
   */
  public function deleteFile()
  {
    try {
      $path = storage_path("/app/private/sync-files/branch/$this->branch_id/$this->file");
      unlink($path);
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
    try {
      $data = [
        'products_updateds' => $sync_products['updateds'],
        'products_errors' => $sync_products['errors'],
        'products_errors_data' => $sync_products['errors_data'],
        'stock_updateds' => $sync_stock['updateds'],
        'stock_errors' => $sync_stock['errors'],
        'stock_error_data' => $sync_stock['error_data'],
      ];
      Mail::send('loftonti.usersystem::mail.sync-databases-mail', $data, function ($message) {
        $message->to('erdwell@gmail.com')
          ->subject('Sincronización de productos.')
          -> attach(storage_path("/app/private/sync-files/branch/$this->branch_id/$this->file"), [
            'as' => $this->file
          ]);
      });
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Send throw error to notify if any method fails
   * @method
   */
  private function sendTrowNotification($errors)
  {
    try {
      Mail::send('loftonti.usersystem::mail.fails-sync-databases-mail', [
        'errors' => $errors
      ], function ($message) {
        $message->to('erdwell@gmail.com')
          ->subject('Sincronización de productos.')
          -> attach(storage_path("/app/private/sync-files/branch/$this->branch_id/$this->file"), [
            'as' => $this->file
          ]);
      });
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  
}
