<?php

namespace LoftonTi\Apiv1\Services\Cars\Usecase;

use LoftonTi\Apiv1\Services\Cars\Repositories\CarEloquentRepository;

class GetCarByNameUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new CarEloquentRepository;
  }

  public function __invoke(string $car_name): ?object
  {
    return $this -> repository -> getByCarName($car_name);
  }

}