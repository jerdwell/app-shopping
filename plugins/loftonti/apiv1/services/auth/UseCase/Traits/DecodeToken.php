<?php

namespace LoftonTi\Apiv1\Services\Auth\UseCase\Traits;

use Firebase\JWT\JWT;

trait DecodeToken
{
  /**
   * get user system by id and check if exists and available
   * @method DecodeToken
   * @param int $id
   */
  private function decodeToken(): void
  {
    try {
      $this -> token_decoded = JWT::decode(
        $this -> token_encoded,
        $this -> user -> pk,
        array('HS256')
      );
    } catch (\Firebase\JWT\ExpiredException $e) {
      JWT::$leeway = 720000;
      $decoded = JWT::decode(
        $this -> token_encoded,
        $this -> user -> pk,
      array('HS256'));
      $this -> token_decoded = $decoded;
      $decoded -> iat = time();
      $decoded -> exp = time() + getenv('TIME_EXPIRES_SESSION_USERS_SYSTEM') + (60 * 60); // Tiempo que expirará el token (+ lo acordado en el .env)
      $this -> refresh_token = JWT::encode($decoded, $this -> user -> pk);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}