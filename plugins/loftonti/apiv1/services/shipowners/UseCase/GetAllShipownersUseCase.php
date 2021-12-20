<?php

namespace LoftonTi\Apiv1\Services\Shipowners\UseCase;

use LoftonTi\Apiv1\Services\Shipowners\Repositories\ShippownerEloquentRepository;

class GetAllShipownersUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new ShippownerEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> all();
  }

}