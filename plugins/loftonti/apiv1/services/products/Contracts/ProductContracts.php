<?php

namespace LoftonTi\Apiv1\Services\Products\Contracts;

interface ProductContracts
{

  public function countActivesByBranch(int $branch_id): object;
  
  public function getProductsMostSelledByBranch(int $branch_id): object;

  public function getAll(): object;

  public function getByErsoCode(string $erso_code): ?object;
  
  public function getInErsoCode(array $codes): ?object;
  
  public function create(array $product, int $branch_id): ?object;
  
  public function deleteMany(array $products): int;
  
  public function update(string $erso_code, array $product): void;

}