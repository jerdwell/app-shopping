<?php

namespace LoftonTi\Apiv1\Services\Cars\Repositories;

use LoftonTi\Apiv1\Services\Cars\Contracts\CarContract;
use Loftonti\Erso\Models\CarsModels;

class CarEloquentRepository implements CarContract
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new CarsModels;
  }

  public function searchCars(string $param): object
  {
    return $this -> repository
      -> where('car_name', 'like', "%$param%")
      -> get();
  }

}