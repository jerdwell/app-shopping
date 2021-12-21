<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase;

use Loftonti\Apiv1\Services\Products\Repositories\ProductEloquentRepository;

class DeleteProductsUseCase
{
  /**
   * @var array
   */
  private $products;

  /**
   * @var object
   */
  private $repository;

  public function __construct(array $products) {
    $this->products = $products;
    $this -> repository = new ProductEloquentRepository;
  }

  public function __invoke()
  {
    return $this 
      -> repository 
      -> deleteMany($this -> products);
  }

}