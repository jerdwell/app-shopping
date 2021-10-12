<?php

namespace LoftonTi\Usersystem\Controllers;
use Loftonti\Erso\Models\Enterprises;

class UserSystemResourcesApi  
{

  public function getAllEnterprises()
  {
    try {
      $enterprises = Enterprises::all();
      return $enterprises;
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 401);
    }
  }

}
