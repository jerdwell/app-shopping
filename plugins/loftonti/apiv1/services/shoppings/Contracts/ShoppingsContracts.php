<?php

namespace Loftonti\Apiv1\Services\Shoppings\Contracts;

interface ShoppingsContracts
{

  public function getOrdersOfMonth(int $branch_id): object;

}