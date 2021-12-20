<?php

namespace LoftonTi\Apiv1\Services\Branches\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Branches\UseCase\GetProductsBranchUseCase;

class GetBranchProductsController
{

  public function __invoke(Request $request)
  {
    try {
      $branch = new GetProductsBranchUseCase($request -> branch_id);
      return $branch($request -> only('per_page', 'order_by', 'order', 'param'));
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ]);
    }
  }

}