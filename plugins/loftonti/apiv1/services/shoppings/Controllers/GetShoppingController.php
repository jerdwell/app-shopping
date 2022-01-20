<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Shoppings\Usecase\GetShoppingUseCase;

class GetShoppingController
{

  public function __invoke(Request $request, int $id)
  {
    try {
      $shopping = new GetShoppingUseCase($id);
      return $shopping();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}