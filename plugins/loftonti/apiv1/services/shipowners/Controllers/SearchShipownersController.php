<?php

namespace LoftonTi\Apiv1\Services\Shipowners\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Shipowners\UseCase\SearchShipownersUseCase;

class SearchShipownersController
{

  public function __invoke(Request $request)
  {
    try {
      $shipowners = new SearchShipownersUseCase($request -> data_search);
      return $shipowners();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}