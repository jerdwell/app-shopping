<?php

namespace LoftonTi\Apiv1\Services\Categories\Repositories;

use LoftonTi\Apiv1\Services\Categories\Contracts\CategoryContract;
use Loftonti\Erso\Models\Categories;

class CategoryEloquentRepository implements CategoryContract
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new Categories;
  }

  public function all(): object
  {
    return $this -> repository -> all();
  }

}