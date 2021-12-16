<?php

namespace Loftonti\Apiv1\Services\Auth\UseCase;

use LoftonTi\Apiv1\Services\Auth\UseCase\Traits\DecodeToken;
use LoftonTi\Apiv1\Services\Auth\UseCase\Traits\ValidExpiration;
use LoftonTi\Apiv1\Services\Auth\UseCase\Traits\ValidUserSystem;

class DecodeTokenUseCase
{
  use 
    ValidUserSystem,
    DecodeToken,
    ValidExpiration;

  /**
   * @var int
   */
  private $user_id;

  /**
   * @var string
   */
  private $type, $token_encoded, $refresh_token;

  /**
   * @var object
   */
  private $token_decoded;

  /**
   * @var object
   */
  private $user;

  public function __construct(int $user_id, string $token_encoded, string $type) {
    $this->user_id = $user_id;
    $this->type = $type;
    $this->token_encoded = str_replace('Bearer ', '', $token_encoded);
    $this -> validToken();
  }

  /**
   * handlle validations of token
   * @method validToken
   */
  public function validToken()
  {
    try {
      if ($this -> type == 'user_system') $this -> validUserSystem($this -> user_id);
      $this -> decodeToken();
      $this -> validExpiration();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getPermissions()
  {
    return $this -> token_decoded -> data -> sign -> rol -> modules;
  }
  
  public function getBranches()
  {
    return $this -> token_decoded -> data -> sign -> branches;
  }

  public function getRefreshToken()
  {
    return $this -> refresh_token;
  }
  
}
