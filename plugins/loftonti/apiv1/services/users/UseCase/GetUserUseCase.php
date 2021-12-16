<?php

namespace Loftonti\Apiv1\Services\Users\UseCase;

use LoftonTi\Apiv1\Services\Users\Repositories\UserEloquentRepository;

class GetUserUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this -> repository = new UserEloquentRepository;
  }
  
  /**
   * get user by username
   * @method getByUsername
   */
  public function getByUsername(string $username): ?object
  {
    $user = $this -> repository -> getByUsername($username);
    if (!$user) return null;
    $user -> avatar;
    $user -> branches;
    $user -> rol;
    $user -> rol -> modules;
    return $user;
  }

  /**
   * Get user by id
   * @method getUserById
   * @param int $id
   */
  public function getById(int $id): ?object
  {
    $user = $this -> repository -> getById($id);
    if (!$user) return null;
    $user -> avatar;
    $user -> branches;
    $user -> rol;
    $user -> rol -> modules;
    return $user;
  }
  
}