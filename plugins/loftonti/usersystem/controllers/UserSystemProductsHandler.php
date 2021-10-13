<?php

namespace LoftonTi\Usersystem\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Usersystem\Classes\UseCases\Products\GetDasboardDataUseCase;

class UserSystemProductsHandler  
{

  /**
   * @method get data dashboard
   */
  public function dashboardData(Request $request)
  {
    try {
      $dashboard = new GetDasboardDataUseCase($request -> branch_id);
      return $dashboard();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 403);
    }
  }
  
}
