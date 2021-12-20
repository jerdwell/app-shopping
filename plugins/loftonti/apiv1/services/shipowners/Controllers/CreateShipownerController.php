<?php

namespace LoftonTi\Apiv1\Services\Shipowners\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Shipowners\Request\CreateShipownerRequest;
use LoftonTi\Apiv1\Services\Shipowners\UseCase\CreateShipownerUseCase;

class CreateShipownerController
{
  use CreateShipownerRequest;

  public function __invoke(Request $request)
  {
    try {
      $this -> validRequest($request);
      $shipowner = new CreateShipownerUseCase($request -> shipowner_name);
      return $shipowner();
    } catch (\Throwable $th) {
      return response()
        -> json(['error' => $th -> getMessage()], 403);
    }
  }

}