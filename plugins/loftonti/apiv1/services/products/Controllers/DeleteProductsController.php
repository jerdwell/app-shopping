<?php

namespace LoftonTi\Apiv1\Services\Products\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Products\UseCase\DeleteProductsUseCase;

class DeleteProductsController
{

  public function __invoke(Request $request)
  {
    try {
      $use_case = new DeleteProductsUseCase($request -> products);
      $use_case();
      return response()
        -> json([
          'message' => 'Los productos de han ado de baja exitosamente.'
        ], 201);
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}