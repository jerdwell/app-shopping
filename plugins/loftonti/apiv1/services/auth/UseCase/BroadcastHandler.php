<?php

namespace Loftonti\Apiv1\Services\Auth\UseCase;
use Firebase\JWT\JWT;

class BroadcastHandler
{
  /**
   * @var string
   */
  private 
    $boradcast_key;
  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this -> boradcast_key = base64_decode(getenv('BROADCAST_PUBLIC_KEY'));
    $this -> repository = new JWT;
  }

  public function crypt(array $crypt_data)
  {
    $now = time();
    $token = array(
      'iat' => $now, // Tiempo que inició el token
      'exp' => $now + (1 * 60 * 60), // 1 hora para expirar el token
      'data' => $crypt_data
    );
    $jwt = $this -> repository -> encode($token, $this -> boradcast_key);
    return $jwt;
  }

  public function decrypt(string $token)
  {
    $token = str_replace('Bearer ', '', $token);
    $data = $this -> repository -> decode(
      $token,
      $this -> boradcast_key,
      array('HS256')
    );
    return $data -> data;
  }

}