<?php

namespace LoftonTi\Apiv1\Services\Customers\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Customers\Request\ListCustomersRequest;
use LoftonTi\Apiv1\Services\Customers\Usecase\ListCustomersUseCase;

class ListCustomersController
{

  use ListCustomersRequest;

  public function __invoke(Request $request)
  {
    try {
      $this -> listCustomersRequests($request);
      $list = new ListCustomersUseCase;
      return $list(
        $request -> per_page,
        $request -> order,
        $request -> order_by,
        $request -> param
      );
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}