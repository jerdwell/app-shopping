<?php

namespace LoftonTi\Apiv1\Services\Billing\Controllers;

use Illuminate\Http\Request;

class TestBillingController
{

  public function __invoke(Request $request)
  {
    try {
      return ['ok'];
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}