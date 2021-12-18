<?php

namespace LoftonTi\Apiv1\Services\Cars\Usecase;

use LoftonTi\Apiv1\Services\Cars\Repositories\CarEloquentRepository;

class GetAllCarsUseCase
{

  /**
   * @var object
   */
  private $repository;
  
  public function __construct() {
    $this->repository = new CarEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> getAll();
  }

}