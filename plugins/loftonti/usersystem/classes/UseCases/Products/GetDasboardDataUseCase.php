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
        'orders_of_the_day' => $this -> getOrderOfTheDay(),
        'products_most_selled' => $this -> getProductsMostSelled()
      ];
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getOrderOfTheDay()
  {
    try {
      $orders = Branches::find($this -> branch_id)
        -> withCount([
          'quotations' => function($q){
            $q -> whereRaw('DATE(created_at) = CURDATE()')
              -> where('status', '!=', 'declined');
          }
        ])
        -> first();
      return $orders -> quotations_count;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getProductsWithLowStock()
  {
    try {
      $products = Branches::find($this -> branch_id)
        -> with(['products' => function($q){
          $q -> where('stock', '<', 10);
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
          $q -> limit(5);
        }])
        -> first();
      return $branch -> products;
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  
}
