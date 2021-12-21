<?php

namespace LoftonTi\Apiv1\Services\Categories\UseCase;

use LoftonTi\Apiv1\Services\Categories\Repositories\CategoryEloquentRepository;

class GetCategoriesUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new CategoryEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> all();
  }

}