<?php

namespace LoftonTi\Apiv1\Services\Products\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Products\UseCase\GetProductByErsoCodeUseCase;

class GetProductController
{

  public function __invoke(Request $request, $erso_code)
  {
    try {
      $product = new GetProductByErsoCodeUseCase($erso_code);
      return $product();
      return $request -> all();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}