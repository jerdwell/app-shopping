<?php

namespace LoftonTi\Apiv1\Services\Products\Contracts;

interface ProductContracts
{

  public function countActivesByBranch(int $branch_id): Object;
  public function getProductsMostSelledByBranch(int $branch_id): Object;

}