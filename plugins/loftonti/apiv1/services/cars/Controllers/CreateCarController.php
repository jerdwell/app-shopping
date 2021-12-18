<?php

namespace LoftonTi\Apiv1\Services\Cars\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Cars\Repositories\CarEloquentRepository;
use LoftonTi\Apiv1\Services\Cars\Request\CreateCarRequest;
use LoftonTi\Apiv1\Services\Cars\Usecase\CreateCarUseCase;

class CreateCarController
{
  use 
    CreateCarRequest;

  public function __invoke(Request $request)
  {
    try {
      $this -> valid($request -> car_name);
      $car = new CreateCarUseCase;
      return $car($request -> car_name);
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }
}