<?php

namespace Loftonti\Usersystem\Classes\UseCases;

use LoftonTi\Usersystem\Models\UserSystem;
use Firebase\JWT\JWT;

class DecodeTokenUseCase  
{

  /**
   * @var int
   */
  private $user_id;

  /**
   * @var string
   */
  private $token_encoded;

  /**
   * @var object
   */
  private $token_decoded;

  /**
   * @var object
   */
  private $user;

  public function __construct(int $user_id, string $token_encoded) {
    $this->user_id = $user_id;
    $this->token_encoded = str_replace('Bearer ', '', $token_encoded);
    $this -> user = new UserSystem;
  }

  public function validToken()
  {
    try {
      $this -> getUserData();
      $this -> decodeToken();
      $this -> validExpiration();
      return ['ok'];
      return [$this -> token_decoded];
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function getUserData(): void
  {
    try {
      $this -> user = $this -> user -> find($this -> user_id);
      if(!$this -> user) throw new \Exception("Bad credentials, this user does not exists.");
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function decodeToken(): void
  {
    try {
      $this -> token_decoded = JWT::decode(
        $this -> token_encoded,
      $this -> user -> pk,
      array('HS256'));
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function validExpiration(): void
  {
    try {
      if(time() > $this -> token_decoded -> exp) throw new \Exception("Token has expired");
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getPermissions()
  {
    return $this -> token_decoded -> data -> rol -> modules;
  }
  
  public function getBranches()
  {
    return $this -> token_decoded -> data -> branches;
  }
  
}
