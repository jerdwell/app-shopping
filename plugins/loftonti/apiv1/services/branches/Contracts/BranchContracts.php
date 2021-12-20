<?php

namespace LoftonTi\Apiv1\services\Branches\Contracts;

interface BranchContracts
{

  public function getById(int $branch_id): ?object;
  
  public function getBranchProducts(int $branch_id, array $data): ?object;

}