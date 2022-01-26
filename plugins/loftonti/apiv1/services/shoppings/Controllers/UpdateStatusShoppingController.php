<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Shoppings\Requests\UpdateOrderStatusRequest;
use LoftonTi\Apiv1\Services\Shoppings\Usecase\GetShoppingUseCase;
use LoftonTi\Apiv1\Services\Shoppings\UseCase\UpdateOrderStatusUseCase;

class UpdateStatusShoppingController
{

  public function __invoke(Request $request)
  {
    try {
      $valid = new UpdateOrderStatusRequest;
      $valid($request);
      $order = new GetShoppingUseCase($request -> id);
      $order = $order();
      if ($order -> branch_id != $request -> branch_id) throw new \Exception("Esta órden no existe");
      $updated = new UpdateOrderStatusUseCase(
        $request -> id, 
        $request -> status, 
        $request -> notes);
      $updated();
      return [
        'message' => 'Órden actualizada exitosamente',
        'status' => 'success'
      ];
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}