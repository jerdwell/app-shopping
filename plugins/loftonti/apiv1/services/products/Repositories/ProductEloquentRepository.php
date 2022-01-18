<?php

namespace Loftonti\Apiv1\Services\Products\Repositories;

use Illuminate\Support\Facades\DB;
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

  public function getByErsoCode(string $erso_code): ?object
  {
    return $this 
      -> repository 
      -> where('erso_code', $erso_code)
      -> with([
        'brand',
        'branches',
        'category',
        'applications' => function($q) {
          $q -> with([
            'car',
            'shipowner'
          ]);
        }
      ])
      -> first();
  }

  public function getInErsoCode(array $codes): object
  {
    return $this 
      -> repository
      -> select('erso_code') 
      -> whereIn('erso_code', $codes)
      -> get();
  }

  public function create(array $product, int $branch_id): ?object
  {
    $transaction = DB::transaction(function() use($product, $branch_id) {
      $p = $this 
        -> repository
        -> create($product);
      $p -> branches() -> attach([
        $branch_id => [
          'enterprise_id' => $product['enterprise_id'],
          'stock' => $product['stock']
        ]
      ]);
      $this -> attachApplications($p, $product['applications']);
      // foreach ($product['applications'] as $application) {
      //   $p -> applications() -> create([
      //     'car_id' => $application['car_id'],
      //     'shipowner_id' => $application['shipowner_id'],
      //     'year' => $application['year'],
      //     'note' => $application['note'],
      //   ]);
      // }
      return $p;
    });
    return $transaction;
  }

  public function deleteMany(array $products): int
  {
    return $this 
      -> repository 
      -> whereIn('erso_code', $products)
      -> update(['product_status' => false]);
  }

  public function update(string $erso_code, array $product): void
  {
    $updated = $this
      -> repository
      -> where('erso_code', $erso_code)
      -> first();
    if ($updated) {
      $updated -> update($product);
      $updated 
        -> branches()
        -> where('id', $product['branch_id'])
        -> where('enterprise_id', $product['branch_id'])
        -> update(['stock' => $product['stock']]);
      $updated -> applications() -> delete();
      $this -> attachApplications($updated, $product['applications']);
    }
  }

  private function attachApplications(object $product, array $applications)
  {
    foreach ($applications as $application) {
      $product -> applications() -> create([
        'car_id' => $application['car_id'],
        'shipowner_id' => $application['shipowner_id'],
        'year' => $application['year'],
        'note' => $application['note'],
      ]);
    }
  }

  public function search(?int $car, ?int $shipowner, ?int $category, ?int $brand, ?int $year, ?string $erso_code): ?object
  {
    return $this -> repository
      -> search($car, $shipowner, $category, $brand, $year, $erso_code);
  }

  public function getById(int $id): ?object
  {
    return $this -> repository ->
      with([
        'applications',
        'brand',
        'branches',
        'category',
        'enterprises'
      ])
      -> find($id);
  }

}