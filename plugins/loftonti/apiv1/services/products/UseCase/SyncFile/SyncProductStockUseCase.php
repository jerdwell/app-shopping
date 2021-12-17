<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase\SyncFile;

use Illuminate\Support\Facades\DB;

class SyncProductStockUseCase
{

  /**
   * @var array
   */
  private $items;

  public function __construct($items) {
    try {
      $this -> items = collect($items) -> map(function($q) {
        return [
          'product_id' => $q['id'],
          'branch_id' => $q['branch_id'],
          'enterprise_id' => $q['enterprise_id'],
          'stock' => $q['stock'],
        ];
      }) -> all();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Main functon to update items
   * @method
   */
  public function __invoke(): array
  {
    try {
      $updateds = 0;
      $errors = 0;
      $error_data = [];
      foreach ($this -> items as $item) {
        try {
          DB::table('loftonti_erso_product_branch')
            -> updateOrInsert([
              'product_id' => $item['product_id'],
              'branch_id' => $item['branch_id'],
              'enterprise_id' => $item['enterprise_id']
            ],[
              'stock' => $item['stock']
            ]);
          $updateds ++;
        } catch (\Throwable $th) {
          $errors ++;
          $error_data[] = ['error' => $th -> getMessage()];
        }
      }
      return [
        'updateds' => $updateds,
        'errors' => $errors,
        'error_data' => $error_data
      ];
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}