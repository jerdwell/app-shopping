<?php

namespace LoftonTi\Apiv1\Services\Customers\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Customers\Usecase\SearchCustomerUseCase;

class SearchCustomerController
{

  public function __invoke(Request $request)
  {
    try {
      $use_case = new SearchCustomerUseCase($request -> search_data);
      return $use_case();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }
  
}