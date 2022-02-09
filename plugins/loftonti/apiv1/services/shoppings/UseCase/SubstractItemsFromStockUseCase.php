<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Usecase;

use Loftonti\Apiv1\Services\Products\Repositories\ProductEloquentRepository;
use LoftonTi\Apiv1\Services\Shoppings\Repositories\ShoppingEloquentRepository;

class SubstractItemsFromStockUseCase
{

  /**
   * @var object
   */
  private $shopping, $repository;

  public function __construct(object $shoping) {
    $this -> shopping = $shoping();
    $this -> repository = new ProductEloquentRepository;
  }

  public function __invoke()
  {
    $products = [];
    foreach ($this -> shopping -> products as $product) {
      try {
        $products[] = $this -> repository -> updateStock($product -> id, $product -> pivot -> quantity, $this -> shopping -> branch_id);
      } catch (\Throwable $th) {
        throw $th;
      }
    }
    return $products;
  }
  
}
