<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\PDFConstructor\UseCase\StreamPDFUseCase;
use LoftonTi\Apiv1\Services\Shoppings\Usecase\GetShoppingUseCase;

class GetShoppingReceiptController
{

  public function __invoke(Request $request, $id)
  {
    try {
      $order = new GetShoppingUseCase($id);
      $order = $order();
      $data_quotation = [
        'order' => $order,
        'logo' => public_path() . '/themes/erso/assets/img/brand/logo_web_erso_white.png'
      ];
      $stream = new StreamPDFUseCase($data_quotation, 'loftonti.apiv1::pdf.receipts.receipt');
      return $stream();
      return $request -> all();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 404);
    }
  }

}