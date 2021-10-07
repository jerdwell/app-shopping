<?php

namespace LoftonTI\UserSystem\Controllers;

use Illuminate\Http\Request;
use LoftonTI\Usersystem\Classes\UseCases\MakeTokenUseCase;

class UserSystemApi
{

  public function authUser(Request $request)
  {
    try {
      if( !$request -> has('username') || !$request -> has('password') ) throw new \Exception("El nombre de usuario  la contraseña son requeridos.");
      $auth = new MakeTokenUseCase(
        $request -> username, 
        $request -> password);
      return $auth -> getToken();
    } catch (\Throwable $th) {
      return response() -> json(['error' => $th -> getMessage()], 400);
    }
  }
  
}
