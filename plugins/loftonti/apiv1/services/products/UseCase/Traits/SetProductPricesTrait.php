<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase\Traits;

trait SetProductPricesTrait
{

  public function setProductPrices(array $prices): array
  {
    $prices = collect($prices);
    $public_price = $prices -> firstWhere('CVE_PRECIO', 1);
    $customer_price = $prices -> firstWhere('CVE_PRECIO', 2);
    if (!$customer_price || !$public_price) throw new \Exception("Se necesita el precio públco y precio cliente para poder dar de allta un auto.");
    
    return [
      'public_price' => $public_price['PRECIO'],
      'customer_price' => $customer_price['PRECIO']
    ];
  }

}