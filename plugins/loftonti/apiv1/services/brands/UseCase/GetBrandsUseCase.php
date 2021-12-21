<?php

namespace LoftonTi\Apiv1\Services\Brands\UseCase;

use LoftonTi\Apiv1\Services\Brands\Repositories\BrandEloquentRepository;

class GetBrandsUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new BrandEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> all();
  }

}
