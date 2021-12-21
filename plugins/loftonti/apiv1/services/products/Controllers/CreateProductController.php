<?php
namespace LoftonTi\Apiv1\Services\Products\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Products\Request\ValidRequestCreateProduct;
use LoftonTi\Apiv1\Services\Products\UseCase\CreateProductUseCase;

class CreateProductController
{

  public function __invoke(Request $request)
  {
    try {
      $valid = new ValidRequestCreateProduct;
      $valid -> valid($request);
      $use_case = new CreateProductUseCase($request -> items, $request -> branch_id);
      return $use_case();
      return $request -> all();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}