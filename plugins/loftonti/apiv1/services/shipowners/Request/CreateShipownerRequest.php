<?php

namespace LoftonTi\Apiv1\Services\Shipowners\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait CreateShipownerRequest
{

  public function validRequest(Request $request): void
  {
    try {
      $validations = Validator::make($request -> all(), [
        'shipowner_name' => 'required|string|unique:loftonti_erso_shipowners,shipowner_name',
      ]);
      if ($validations -> fails()) {
        if ($validations -> errors() -> has('shipowner_name')) throw new \Exception("Esta armadora ya se encuentra registrada.");
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}