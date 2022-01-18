<?php

namespace LoftonTi\Apiv1\Services\Products\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Products\UseCase\SearchProductsUseCase;

class SearchProductsController
{

  public function __invoke(Request $request)
  {
    try {
      $use_case = new SearchProductsUseCase(
        $request -> car,
        $request -> shipowner,
        $request -> category,
        $request -> brand,
        $request -> year,
        $request -> erso_code);
      return $use_case();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}