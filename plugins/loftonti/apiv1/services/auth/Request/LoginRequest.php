<?php

namespace LoftonTi\Apiv1\Services\Auth\Request;

class LoginRequest
{
  /**
   * @var Object
   */
  protected $request;

  protected function validation() {
    if ( !$this -> request -> has('username') || !$this -> request -> has('password') ) throw new \Exception("El nombre de usuario  la contraseña son requeridos.");
  }
}