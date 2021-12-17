<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase;

use Loftonti\Apiv1\Services\Products\Repositories\ProductEloquentRepository;

class GetAllProductsUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new ProductEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> getAll();
  }

}