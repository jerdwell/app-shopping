<?php

namespace LoftonTi\Apiv1\Services\Applications\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Brands\UseCase\GetBrandsUseCase;
use LoftonTi\Apiv1\Services\Cars\Usecase\GetAllCarsUseCase;
use LoftonTi\Apiv1\Services\Categories\UseCase\GetCategoriesUseCase;
use LoftonTi\Apiv1\Services\Shipowners\UseCase\GetAllShipownersUseCase;

class GetDataApplicationsController
{

  public function __invoke(Request $request)
  {
    try {
      $shipowners = new GetAllShipownersUseCase;
      $cars = new GetAllCarsUseCase;
      $brands = new GetBrandsUseCase;
      $categories = new GetCategoriesUseCase;
      return [
        'cars' => $cars(),
        'shipowners' => $shipowners(),
        'brands' => $brands(),
        'categories' => $categories()
      ];
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ]);
    }
  }

}