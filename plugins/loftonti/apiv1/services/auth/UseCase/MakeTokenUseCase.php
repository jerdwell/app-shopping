<?php

namespace Loftonti\Apiv1\Services\Auth\UseCase;

use Firebase\JWT\JWT;

class MakeTokenUseCase
{

  /**
   * @var string
   */
  private
    $name,
    $pk,
    $token;

  /**
   * @var int
   */
  private $id;
  /**
   * @var object
   */
  private $data;

  /**
   * @param int $id
   * @param int $name
  *  @param null|array $rol
  *  @param null|array $branches
   * }
   */
  public function __construct($id, $name, $pk, $data)
  {
    $this->id = $id;
    $this->name = $name;
    $this->pk = $pk;
    $this->data = $data;
    $this -> prepareToken();
    $this -> makeToken();
  }

  private function prepareToken(): void
  {
    try {
      $this -> data_token = [
        'id' => $this -> id,
        'name' => $this -> name,
        'sign' => $this -> data
      ];
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function makeToken()
  {
    try {
      $now = time();
      $key = $this -> pk;
      $token = array(
        'iat' => $now, // Tiempo que inició el token
        'exp' => $now + getenv('TIME_EXPIRES_SESSION_USERS_SYSTEM') + (60 * 60), // Tiempo que expirará el token (+ lo acordado en el .env)
        'data' => $this -> data_token
      );

      $jwt = JWT::encode($token, $key);
      $this -> token = $jwt;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getToken(): string
  {
    return $this -> token;
  }
  
}
