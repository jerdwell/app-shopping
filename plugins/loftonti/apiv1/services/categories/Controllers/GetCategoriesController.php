<?php

namespace LoftonTi\Apiv1\Services\Categories\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Categories\UseCase\GetCategoriesUseCase;

class GetCategoriesController
{

  public function __invoke(Request $request)
  {
    try {
      $categories = new GetCategoriesUseCase;
      return $categories();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'message' => $th -> getMessage()
        ]);
    }
  }

}