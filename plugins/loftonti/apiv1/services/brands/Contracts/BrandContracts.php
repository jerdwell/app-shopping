<?php

namespace LoftonTi\Apiv1\Services\Brands\Contracts;

interface BrandContracts
{

  public function search(string $param): object;
  
  public function all(): object;

}