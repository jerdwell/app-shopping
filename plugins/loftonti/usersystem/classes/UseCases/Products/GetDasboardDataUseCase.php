<?php

namespace LoftonTi\Usersystem\Classes\UseCases\Products;

use Loftonti\Erso\Models\Branches;

class GetDasboardDataUseCase
{

  /**
   * @var int
   */
  private $branch_id;

  public function __construct(int $branch_id) {
    $this->branch_id = $branch_id;
  }

  public function __invoke()
  {
    try {
      return [
        'branch_id' => $this -> branch_id,
        'all_products' => $this -> getCountAllProducts(),
        'products_low_stock' => $this -> getProductsWithLowStock(),
        'orders_of_the_month' => $this -> getOrderOfTheMonth(),
        'products_most_selled' => $this -> getProductsMostSelled()
      ];
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getOrderOfTheMonth()
  {
    try {
      $orders = Branches::find($this -> branch_id)
        -> withCount([
          'orders' => function($q){
            $q -> whereRaw('Month(updated_at) = MONTH(CURRENT_DATE())')
            -> whereRaw('Year(updated_at) = Year(CURRENT_DATE())')
            -> where('status', 'shipped');
          }
        ])
        -> first();
      return $orders -> orders_count;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getProductsWithLowStock()
  {
    try {
      $products = Branches::find($this -> branch_id)
        -> with(['products' => function($q){
          $q -> where('stock', 0);
        }])
        -> first();
      return count($products -> products);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getCountAllProducts()
  {
    try {
      $branch = Branches::find($this -> branch_id);
      if(!$branch) throw new \Exception("This branch does not exists.");
      $b = $branch -> withCount(['products' => function($q){
        $q -> where('product_status', true);
      }])
      ->first();
      return $b -> products_count;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getProductsMostSelled()
  {
    try {
      $branch = Branches::find($this -> branch_id)
        -> with(['products' => function($q){
          $q -> withCount([
            'orders'
          ])
          -> whereHas('orders')
          -> orderBy('orders_count', 'desc')
          -> limit(5);
        }])
        -> first();
      return $branch -> products;
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  
}
