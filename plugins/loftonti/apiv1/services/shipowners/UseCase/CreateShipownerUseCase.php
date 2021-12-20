<?php

namespace LoftonTi\Apiv1\Services\Shipowners\UseCase;

use LoftonTi\Apiv1\Services\Shipowners\Repositories\ShippownerEloquentRepository;

class CreateShipownerUseCase
{
  /**
   * @var object
   */
  private $repository;
  /**
   * @var string
   */
  private $shipowner_name;

  public function __construct(string $shipowner_name) {
    $this->shipowner_name = $shipowner_name;
    $this -> repository = new ShippownerEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> create($this -> shipowner_name);
  }
}