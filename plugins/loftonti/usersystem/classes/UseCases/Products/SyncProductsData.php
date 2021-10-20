<?php

namespace LoftonTi\UserSystem\Classes\UseCases\Products;

use Illuminate\Support\Facades\DB;

class SyncProductsData
{

  /**
   * @var array
   */
  private $items;

  public function __construct(array $items) {
    try {
      $this->items = $items;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function __invoke(): array
  {
    try {
      $updateds = 0;
      $errors = 0;
      $errors_data = [];
      foreach ($this -> items as $item) {
        try {
          DB::table('loftonti_erso_products')
            -> where('id', $item['id'])
            -> update([
              'product_status' => $item['product_status'],
              'customer_price' => $item['customer_price'],
              'public_price' => $item['public_price'],
              'product_cover' => $item['product_cover'],
            ]);
            $updateds ++;
        } catch (\Throwable $th) {
          $errors ++;
          $errors_data[] = [
            'error' => $th -> getMessage()
          ];
        }
      }
      return [
        'updateds' => $updateds,
        'errors' => $errors,
        'errors_data' => $errors_data,
      ];
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}
