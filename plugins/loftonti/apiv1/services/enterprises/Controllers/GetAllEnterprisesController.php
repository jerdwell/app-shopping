<?php

namespace LoftonTi\Apiv1\Services\Enterprises\Controllers;

use LoftonTi\Apiv1\Services\Enterprises\Usecase\GetEnterprisesUseCase;

class GetAllEnterprisesController
{

  public function __invoke()
  {
    try {
      $enterprises = new GetEnterprisesUseCase;
      return $enterprises();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }
  
}