<?php
namespace LoftonTi\Apiv1\Services\Customers\Contracts;

interface CustomerContracts
{

  public function create(array $customer): object;

}