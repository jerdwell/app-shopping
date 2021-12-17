<?php

namespace LoftonTi\Apiv1\Services\Cars\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Cars\Repositories\CarEloquentRepository;

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
    return $this -> repository -> searchCars($request -> data_search);
  }
}