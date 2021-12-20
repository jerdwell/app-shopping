<?php

namespace LoftonTi\Apiv1\Services\Shipowners\Repositories;

use LoftonTi\Apiv1\Services\Shipowners\Contracts\ShipownerContracts;
use Loftonti\Erso\Models\Shipowners;

class ShippownerEloquentRepository implements ShipownerContracts
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new Shipowners;
  }

  public function search(string $param): ?object
  {
    return $this -> repository -> where('shipowner_name', 'like', "%$param%")
      -> get();
  }

  public function create(string $shipowner_name): object
  {
    return $this -> repository -> create([
      'shipowner_name' => $shipowner_name
    ]);
  }

}