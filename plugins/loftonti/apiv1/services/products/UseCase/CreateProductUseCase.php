<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase;

use Loftonti\Apiv1\Services\Products\Repositories\ProductEloquentRepository;

class CreateProductUseCase
{

  /**
   * @var int
   */
  private $assertions = 0, $branch_id;
  /**
   * @var object
   */
  private 
    $repository;

  /**
   * @var array
   */
  private $items, $errors = [];

  public function __construct($products, $branch_id) {
    $this -> products = $products;
    $this -> branch_id = $branch_id;
    $this->repository = new ProductEloquentRepository;
  }

  public function __invoke()
  {
    $products = [];
    $setProducts = new SetDataProductUseCase();
    foreach ($this -> products as $product) {
      try {
        $p = $setProducts($product);
        $this -> repository -> create($p, $this -> branch_id);
        $products[] = $p;
      } catch (\Throwable $th) {
        $this -> errors[] = "Producto problema en el producto {$product['CVE_ART']}: " . $th -> getMessage();
      }
    }
    return [
      'errors' => $this -> errors,
      'assertions' => $this -> assertions,
      'products' => $products
    ];
  }

}