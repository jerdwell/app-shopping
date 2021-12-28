<?php

namespace LoftonTi\Apiv1\Services\Cars\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Cars\Repositories\CarEloquentRepository;
use LoftonTi\Apiv1\Services\Cars\Usecase\SearchCarUseCase;

class SearchCarsController
{
  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new CarEloquentRepository;
  }
  /**
   * Return list of cars matched with param
   * @method 
   */
  public function __invoke(Request $request)
  {
    try {
      $cars = new SearchCarUseCase;
      return $cars($request -> data_search);
    } catch (\Throwable $th) {
      return response()
        -> json(['error' => $th -> getMessage()], 403);
    }
  }
}