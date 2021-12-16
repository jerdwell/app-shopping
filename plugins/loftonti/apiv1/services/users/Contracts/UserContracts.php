<?php

namespace LoftonTi\Apiv1\Services\Users\Contracts;

interface UserContracts
{

  public function getByUsername($username): ?object;
  
  public function getById($id): ?object;

}