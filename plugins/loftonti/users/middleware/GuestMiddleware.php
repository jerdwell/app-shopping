<?php namespace Loftonti\Users\Middleware;

use Closure;
use Illuminate\Http\Request;
use LoftonTi\Users\Models\UsersAuth;

class GuestMiddleware 
{

  /**
   * Handle auth user to api
   * @param Illuminate\Support\Facades\Request $request
   * @param \Closure $next
   * @return mixed
   */

   public function handle($request, Closure $next)
   {
      try {
        UsersAuth::validRequest($request);
        return $next($request);
      } catch (\Exception $th) {
        return $next($request);
      }
   }
  
}
