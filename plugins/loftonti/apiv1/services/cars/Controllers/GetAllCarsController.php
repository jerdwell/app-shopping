<?php

namespace LoftonTi\Apiv1\Services\Cars\Controllers;

use LoftonTi\Apiv1\Services\Cars\Usecase\GetAllCarsUseCase;

class GetAllCarsController
{

  /**
   * Retrivie all cars
   * @method
   */
  public function __invoke()
  {
    try {
      $cars = new GetAllCarsUseCase;
      return $cars();
    } catch (\Throwable $th) {
      return response()
        -> json(['error' => $th -> getMessage()], 403);
    }
  }

}