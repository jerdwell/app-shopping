<?php

namespace LoftonTi\Apiv1\Services\Brands\Repositories;

use LoftonTi\Apiv1\Services\Brands\Contracts\BrandContracts;
use Loftonti\Erso\Models\Brands;

class BrandEloquentRepository implements BrandContracts
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new Brands;
  }

  public function search(string $param): object
  {
    return $this 
      -> repository 
      -> where('brand_name', 'like', "%$param%")
      -> get();
  }

  public function all(): object
  {
    return $this 
      -> repository 
      -> all();
  }

}