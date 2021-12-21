<?php

namespace LoftonTi\Apiv1\Services\Products\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Products\Request\ValidUpdateProductRequest;
use LoftonTi\Apiv1\Services\Products\UseCase\UpdateProductUseCase;

class UpdateProductController
{

  public function __invoke(Request $request)
  {
    try {
      $valid = new ValidUpdateProductRequest($request);
      $valid();
      $update = new UpdateProductUseCase($request -> all());
      return $update();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}