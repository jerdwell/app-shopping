<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Shoppings\Requests\ListShoppingsRequest;
use LoftonTi\Apiv1\Services\Shoppings\UseCase\ListShoppingsUseCase;

class ListShoppingsController
{

  public function __invoke(Request $request)
  {
    try {
      $valid = new ListShoppingsRequest;
      $valid($request);
      $list = new ListShoppingsUseCase(
        $request -> begin, 
        $request -> end, 
        $request -> order,
        $request -> branch_id,
        $request -> customer_id,
        $request -> limit);
      return $list();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}