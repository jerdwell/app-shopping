<?php

namespace LoftonTi\Apiv1\Services\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Auth\Request\Traits\SetHeadersRequest;
use Loftonti\Apiv1\Services\Auth\UseCase\DecodeTokenUseCase;

class UserSystemAuthMiddleware
{
  use SetHeadersRequest;

  /**
   * @var int
   */
  private 
    $branch_id,
    $bearer_token,
    $user_id;

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
      $this -> checkHeaders($request);
      $this -> permission = $permission;
      $this -> module = $module;
      $token = new DecodeTokenUseCase(
        $this -> user_id, 
        $this -> bearer_token,
        'user_system'
      );
      $refresh_token = $token -> getRefreshToken();
      $this -> permissions = $token -> getPermissions();
      $this -> branches = $token -> getBranches();
      $this -> checkBranchAssigned();
      if($this -> module && $this -> permission) $this -> checkPermission();
      $request -> request -> add([
        'branch_id' => $this -> branch_id,
        'user_id' => $this -> user_id,
      ]);
      $response = $next($request);
      if($refresh_token) $response -> header('Refresh-Token', $refresh_token);
      return $response;
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
