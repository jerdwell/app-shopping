<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LoftonTi\Apiv1\Services\Billing\UseCase\CancelBilleableUseCase;
use LoftonTi\Apiv1\services\Billing\UseCase\CancelInvoiceUseCase;
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
      if ($request -> status === 'cancelled')
      {
        DB::transaction(function() use ($request, $order){
          $updated = new UpdateOrderStatusUseCase(
            $request -> id, 
            $request -> status, 
            $request -> notes);
          $updated();
          $cancel_billeabe = new CancelBilleableUseCase();
          $cancel_billeabe -> handler($order, $request -> invoice_motive);
        });
      }
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