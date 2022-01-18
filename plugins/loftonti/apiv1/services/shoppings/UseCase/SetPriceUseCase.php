<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Usecase;

class SetPriceUseCase
{

  static function price(object $product, ?object $customer): string
  {
    if (!isset($customer -> type)) return $product -> public_price;
    $price = [
      'guest' => $product -> public_price,
      'customer' => $product -> customer_price,
    ];
    return $price[$customer ? $customer -> type : 'guest'];
  }

}