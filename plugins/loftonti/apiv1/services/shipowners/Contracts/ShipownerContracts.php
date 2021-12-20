<?php

namespace LoftonTi\Apiv1\Services\Shipowners\Contracts;

interface ShipownerContracts
{

  public function search(string $param): ?object;
  
  public function create(string $shipowner_name): ?object;

}