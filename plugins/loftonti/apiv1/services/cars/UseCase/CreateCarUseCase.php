<?php

namespace LoftonTi\Apiv1\Services\Cars\Usecase;

use LoftonTi\Apiv1\Services\Cars\Repositories\CarEloquentRepository;

class CreateCarUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new CarEloquentRepository;
  }

  public function __invoke(string $car_name)
  {
    return $this -> repository 
      -> create(['car_name' => $car_name]);
  }

}