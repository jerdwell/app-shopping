<?php

namespace LoftonTi\Apiv1\Services\Brands\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Brands\UseCase\GetBrandsUseCase;

class GetBrandsController
{

  public function __invoke(Request $request)
  {
    try {
      $brands = new GetBrandsUseCase;
      return $brands();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}