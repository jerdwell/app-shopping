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

  public function create(array $product_data): object
  {
    try {
      return $this -> repository -> create([
        'car_name' => $product_data['car_name']
      ]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getByCarName(string $param): ?object
  {
    return $this -> repository
      -> where('car_name', $param)
      -> first();
  }

  public function getAll(): object
  {
    return $this -> repository -> all();
  }

}