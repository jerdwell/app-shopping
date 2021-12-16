<?php

namespace LoftonTi\Apiv1\Services\Users\Repositories;

use LoftonTi\Apiv1\Services\Users\Contracts\UserContracts;
use LoftonTi\Usersystem\Models\UserSystem as User;

class UserEloquentRepository implements UserContracts
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this -> repository = new User;
  }

  public function getByUsername($user_name): ?User
  {
    return $this -> repository -> where('username', $user_name)
      -> first();
  }

  public function getById($id): ?User
  {
    return $this -> repository -> where('id', $id)
      -> first();
  }

}