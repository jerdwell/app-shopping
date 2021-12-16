<?php

namespace LoftonTi\Apiv1\Services\Auth\Request\Traits;

use Illuminate\Http\Request;

trait SetHeadersRequest
{

  /**
   * Check if headers auth are present and set data authorization
   * @method checkHeaders
   * @return void
   */
  private function checkHeaders(Request $request): void
  {
    if(!$request -> headers -> has('Authorization')) throw new \Exception("Error: Not credentials in request");
    if(!$request -> headers -> has('Auth-User')) throw new \Exception("Error: Not credentials in request");
    if(!$request -> headers -> has('Auth-Branch')) throw new \Exception("Error: Not credentials in request");
    $this -> bearer_token = $request -> header('Authorization');
    $this -> user_id = $request -> header('Auth-User');
    $this -> branch_id = $request -> header('Auth-Branch');
  }
  
}
