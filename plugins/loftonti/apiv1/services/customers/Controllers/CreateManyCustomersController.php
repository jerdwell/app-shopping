<?php

namespace LoftonTi\Apiv1\Services\Customers\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Customers\Request\CreateManyCustmersRequest;
use LoftonTi\Apiv1\Services\Customers\Usecase\CreateCustomerUseCase;
use LoftonTi\Apiv1\Services\Customers\Usecase\GetCustomerByColUseCase;

class CreateManyCustomersController
{

  public function __invoke(Request $request)
  {
    try {
      $valid = new CreateManyCustmersRequest;
      $valid($request);
      $get_customer = new GetCustomerByColUseCase;
      $use_case = new CreateCustomerUseCase;
      foreach ($request -> items as $customer) {
        $exists = $get_customer('email', $customer['email']);
        if (!$exists) $use_case($customer, 'customer', true);
      }
      return response()
        -> json(['message' => 'Los clientes que no tengan coincidencias de correo o RFC se darán de alta exitosamente.'], 201);
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}