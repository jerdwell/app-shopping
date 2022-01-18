<?php

namespace LoftonTi\Apiv1\Services\Applications\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Applications\Usecase\GetYearsRangeUseCase;

class GetYearsController
{

  public function __invoke(Request $request)
  {
    try {
      $years = new GetYearsRangeUseCase($request -> car, $request -> shipowner);
      $years = $years();
      return [
        "start" => $years[0] -> start,
        "end" => $years[0] -> end
      ];
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}