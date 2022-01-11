<?php
namespace LoftonTi\Apiv1\Services\Customers\Contracts;

interface CustomerContracts
{

  public function create(array $customer): object;
  
  public function get(int $id): ?object;
  
  public function list(?int $per_page, ?string $order, ?string $order_by, ?string $param): ?object;
  
  public function update(array $customer): ?object;

  public function getByCol(string $col, string $value): ?object;

}