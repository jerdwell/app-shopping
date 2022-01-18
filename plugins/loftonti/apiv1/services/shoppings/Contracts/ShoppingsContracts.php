<?php

namespace Loftonti\Apiv1\Services\Shoppings\Contracts;

interface ShoppingsContracts
{

  public function create(array $order_data, array $items, array $shopping_contact): object;
  
  public function getOrdersOfMonth(int $branch_id): object;

}