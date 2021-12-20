<?php

namespace LoftonTi\Apiv1\Services\Applications\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Cars\Usecase\GetAllCarsUseCase;
use LoftonTi\Apiv1\Services\Shipowners\UseCase\GetAllShipownersUseCase;

class GetDataApplicationsController
{

  public function __invoke(Request $request)
  {
    try {
      $shipowners = new GetAllShipownersUseCase;
      $cars = new GetAllCarsUseCase;
      return [
        'cars' => $cars(),
        'shipowners' => $shipowners()
      ];
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ]);
    }
  }

}