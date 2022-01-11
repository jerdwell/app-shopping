<?php

namespace LoftonTi\Apiv1\Services\Customers\Controllers;
use Illuminate\Support\Facades\Queue;
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
      $customer = $customer(
        $request -> only('email', 'phone', 'full_name', 'address', 'password'), 
        'customer', true);
      Queue::push('LoftonTi\Apiv1\Services\Customers\Jobs\CustomerRegisterNotification', $request -> all());
      return $customer;
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}