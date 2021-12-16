<?php
namespace LoftonTi\Apiv1\Services\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use LoftonTi\Apiv1\Services\Auth\Request\LoginRequest;
use Loftonti\Apiv1\Services\Auth\UseCase\MakeTokenUseCase;
use LoftonTi\Apiv1\Services\Auth\UseCase\UserSystemMakeToken;
use Loftonti\Apiv1\Services\Users\UseCase\GetUserUseCase;

class LoginUserController extends LoginRequest
{

  /**
   * @var object
   */
  protected $request;

  public function __invoke(Request $request)
  {
    try {
      $this -> request = $request;
      $this -> validation();
      $user = new GetUserUseCase;
      $user = $user -> getByUsername($request -> username);
      if (!$user) throw new \Exception("Credenciales inválidas");
      $check = Hash::check($request -> password, $user -> password);
      if (!$check) throw new \Exception("Credenciales inválidas");
      $token = new UserSystemMakeToken;
      return $token($user);
    } catch (\Throwable $th) {
      return response() -> json(['error' => $th -> getMessage()], 400);
    }
  }

}