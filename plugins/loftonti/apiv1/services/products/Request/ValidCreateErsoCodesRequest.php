<?php

namespace LoftonTi\Apiv1\Services\Products\Request;

use LoftonTi\Apiv1\Services\Products\UseCase\GetProductsInErsoCodesUseCase;

trait ValidCreateErsoCodesRequest
{

  private function validErsoCodes($request): void
  {
    $codes = collect($request -> items) -> map(function ($q){
      return $q['CVE_ART'];
    }) -> all();
    $use_case = new GetProductsInErsoCodesUseCase($codes);
    $repeated = collect($use_case()) -> map(function($q){
      return $q -> erso_code;
    }) -> all();
    if (count($repeated) > 0) throw new \Exception("Algunos de los códigos están duplicados, valida la información: " . join(',', $repeated));
  }

}