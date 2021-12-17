<?php

namespace Loftonti\Apiv1\Services\Products\Repositories;

use LoftonTi\Apiv1\Services\Products\Contracts\ProductContracts;
use Loftonti\Erso\Models\Products;

class ProductEloquentRepository implements ProductContracts
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this -> repository = new Products;
  }

  public function countActivesByBranch(int $branch_id): object
  {
    $products = $this -> repository -> selectRaw('count(id) as all_products')
      -> join('loftonti_erso_product_branch', 'product_id', 'id')
      -> where('branch_id', $branch_id)
      -> where('product_status', true)
      -> first();
    return $products;
  }

  public function getProductsMostSelledByBranch(int $branch_id): object
  {
    $products = $this -> repository
      -> selectRaw('loftonti_erso_products.*, count(shopping_id) as shoppings')
      -> join('loftonti_shoppings_shopping_products', 'product_id', 'id')
      -> join('loftonti_shoppings_shopping', 'branch_id', 'loftonti_shoppings_shopping_products.shopping_id')
      -> groupBy('product_id')
      -> where('product_status', true)
      -> where('loftonti_shoppings_shopping.branch_id', $branch_id)
      -> whereRaw('MONTH(loftonti_shoppings_shopping.updated_at) = MONTH(CURRENT_DATE())')
      -> whereRaw('YEAR(loftonti_shoppings_shopping.updated_at) = YEAR(CURRENT_DATE())')
      -> take(5)
      -> get();
    return $products;
  }

  public function getAll(): object
  {
    return $this -> repository 
      -> where('product_status', true)
      -> get();
  }

}