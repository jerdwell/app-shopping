<?php

namespace Loftonti\Usersystem\Classes\UseCases;

use LoftonTI\Usersystem\Classes\UseCases\AuthUserUseCase;
use Firebase\JWT\JWT;

class MakeTokenUseCase extends AuthUserUseCase
{

  /**
   * @var string
   */
  private
    $username,
    $password, 
    $token,
    $sk,
    $pk;
  /**
   * @var int
   */
  private $id;
  /**
   * @var object
   */
  private $rol, $data_token;

  public function __construct(string $username, string $password)
  {
    $this->username = $username;
    $this->password = $password;
    parent::__construct($this -> username, $this -> password);
    $this -> prepareToken();
    $this -> makeToken();
  }

  private function prepareToken(): void
  {
    try {
      $this -> data_token = [ // información del usuario
        'id' => $this -> getId(),
        'name' => $this -> getName(),
        'rol' => $this -> getRol(),
        'branches' => $this -> getBranches()
      ];
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function makeToken()
  {
    try {
      $now = time();
      $key = $this -> getPk();
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

  public function getToken(): array
  {
    return [
      'user' => $this -> data_token,
      'token' => $this -> token
    ];
  }
  
}
