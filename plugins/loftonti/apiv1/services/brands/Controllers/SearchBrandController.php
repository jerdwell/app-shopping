<?php

namespace LoftonTi\Apiv1\Services\Brands\Controllers;

use Illuminate\Http\Request;
use Loftonti\Apiv1\Services\Brands\UseCase\SearchBrandUseCase;

class SearchBrandController
{

  public function __invoke(Request $request)
  {
    try {
      $use_case = new SearchBrandUseCase($request -> data_search);
      return $use_case();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}