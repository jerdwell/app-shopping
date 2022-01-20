<?php

namespace LoftonTi\Apiv1\Services\Billing\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Billing\UseCase\CreateInvoiceUseCase;
use LoftonTi\Apiv1\Services\Billing\UseCase\CreateReceiptUseCase;
use Loftonti\Apiv1\Services\Billing\UseCase\SendByEmailInvoiceUseCase;
use LoftonTi\Shoppings\Classes\UseCases\GetOrderUseCase;

class TestBillingController
{

  public function __invoke(Request $request)
  {
    try {
      $order = new GetOrderUseCase(31, 1);
      $receipt = new CreateInvoiceUseCase($order -> getOrderData(), null);
      $receipt = $receipt();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}