<?php

namespace LoftonTi\Apiv1\Services\Customers\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Customers\Request\NewCustomerRequest;
use LoftonTi\Apiv1\Services\Customers\Usecase\UpdateCustomerUseCase;

class UpdateCustomerController
{

  use NewCustomerRequest;

  public function __invoke(Request $request)
  {
    try {
      $this -> validNewCustomer($request);
      $use_case = new UpdateCustomerUseCase;
      return $use_case($request -> all());
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}