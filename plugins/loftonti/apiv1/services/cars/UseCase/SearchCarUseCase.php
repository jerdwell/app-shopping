<?php

namespace LoftonTi\Apiv1\Services\Cars\Usecase;

use LoftonTi\Apiv1\Services\Cars\Repositories\CarEloquentRepository;

class SearchCarUseCase
{
  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new CarEloquentRepository;
  }

  public function __invoke(string $param)
  {
    return $this -> repository -> searchCars($param);
  }
}