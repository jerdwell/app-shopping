<?php

namespace Loftonti\Apiv1\Services\Shoppings\Contracts;

interface ShoppingsContracts
{

  public function create(array $order_data, array $items, array $shopping_contact): object;
  
  public function getOrdersOfMonth(int $branch_id): object;

  public function list(string $begin, string $end, string $order, ?int $branch_id, ?int $customer_id, int $limit): object;
  
  public function find(int $id): ?object;

  public function updateStatus(int $id, string $status, ?string $notes): bool;

}