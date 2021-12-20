<?php

namespace LoftonTi\Apiv1\Services\Shipowners\UseCase;

use LoftonTi\Apiv1\Services\Shipowners\Repositories\ShippownerEloquentRepository;

class SearchShipownersUseCase
{
  /**
   * @var object
   */
  private $repository;

  /**
   * @var string
   */
  private $param;

  public function __construct(string $param) {
    $this->param = $param;
    $this -> repository = new ShippownerEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> search($this -> param);
  }

}