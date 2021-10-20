<?php

namespace LoftonTi\Usersystem\Middleware;

use Closure;
use Illuminate\Http\Request;
use Loftonti\Usersystem\Classes\UseCases\Auth\DecodeTokenUseCase;

class UserSystemAuthMiddleware
{

  /**
   * @var int
   */
  private $branch_id;

  /**
   * @var null|string
   */
  private $module, $permission;
  /**
   * @var object
   */
  private $permissions, $branches;

  /**
   * Middleware to handle auth user
   * @method
   * @param $request handle http data
   * @param $next 
   */
  public function handle(Request $request, Closure $next, ?string $module = null, ?string $permission = null)
  {
    try {
      if(!$request -> headers -> has('Authorization')) throw new \Exception("Error: Not credentials in request");
      if(!$request -> headers -> has('Auth-User')) throw new \Exception("Error: Not credentials in request");
      if(!$request -> headers -> has('Auth-Branch')) throw new \Exception("Error: Not credentials in request");
      $this -> permission = $permission;
      $this -> module = $module;
      $this -> branch_id = $request -> headers -> get('Auth-Branch');
      $token = new DecodeTokenUseCase($request -> headers -> get('Auth-User'), $request -> headers -> get('Authorization'));
      $token -> validToken();
      $this -> permissions = $token -> getPermissions();
      $this -> branches = $token -> getBranches();
      $this -> checkBranchAssigned();
      if($this -> module && $this -> permission ) $this -> checkPermission();
      $request -> request -> add([
        'branch_id' => $this -> branch_id,
        'user_id' => $request -> headers -> get('Auth-User'),
      ]);
      return $next($request);
    } catch (\Throwable $th) {
      return response() 
        -> json([
          'error' => $th -> getMessage()
        ], 401);
    }
  }

  private function checkPermission()
  {
    try {
      $error_message = "Bad credentials: you dont have permissiions for this action.";
      $module = collect($this -> permissions) -> firstWhere("slug", "===", $this -> module);
      if(!$module) throw new \Exception($error_message);
      $p = $this -> permission;
      if(!$module -> pivot -> $p) throw new \Exception($error_message);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function checkBranchAssigned()
  {
    try {
      $error_message = 'Bad credentials: you dont have this branch assigned,';
      $branch = collect($this -> branches) -> firstWhere('id', '==', $this -> branch_id);
      if(!$branch) throw new \Exception($error_message);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}
