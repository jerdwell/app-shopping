<?php

namespace LoftonTi\Apiv1\Services\Customers\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Customers\Usecase\GetCustomerUseCase;

class GetCustomerController
{

  public function __invoke(Request $request, int $id)
  {
    try {
      $customer = new GetCustomerUseCase;
      return $customer($id);
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}