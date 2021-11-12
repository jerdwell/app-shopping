<?php

namespace LoftonTi\Usersystem\Classes\UseCases\Products;

use Loftonti\Erso\Models\Brands;

class GetBrandsUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new Brands;
  }

  public function __invoke(): object
  {
    return $this -> repository -> all();
  }

}