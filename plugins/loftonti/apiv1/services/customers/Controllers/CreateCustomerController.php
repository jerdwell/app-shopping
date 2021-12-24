<?php

namespace LoftonTi\Apiv1\Services\Customers\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Customers\Request\NewCustomerRequest;
use LoftonTi\Apiv1\Services\Customers\Usecase\CreateCustomerUseCase;

class CreateCustomerController
{
  use NewCustomerRequest;

  public function __invoke(Request $request)
  {
    try {
      $this -> validNewCustomer($request);
      $customer = new CreateCustomerUseCase;
      return $customer(
        $request -> only('email', 'phone', 'full_name', 'address', 'password'), 
        'customer', true);
      return $request -> all();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ]);
    }
  }

}