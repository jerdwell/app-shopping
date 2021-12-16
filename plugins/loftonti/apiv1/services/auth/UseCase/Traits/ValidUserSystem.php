<?php

namespace LoftonTi\Apiv1\Services\Auth\UseCase\Traits;

use Loftonti\Apiv1\Services\Users\UseCase\GetUserUseCase;

trait ValidUserSystem
{
  
  /**
   * get user system by id and check if exists and available
   * @method validUserSystem
   * @param int $id
   */
  function validUserSystem(int $id): void
  {
    $user = new GetUserUseCase;
    $user = $user -> getById($id);
    if (!$user || $user -> deleted_at) throw new \Exception("Bad credentials");
    $this -> user = $user;
  }
}