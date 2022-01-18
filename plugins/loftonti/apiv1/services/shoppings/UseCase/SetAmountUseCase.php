<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Usecase;

class SetAmountUseCase
{

  static function productAmount(string $price, int $quantity): string
  {
    return $price * $quantity;
  }

  static public function orderAmount(array $items): string
  {
    $amount = 0.00;
    foreach ($items as $item) {
      $amount += $item['current_price'] * $item['quantity'];
    }
    return $amount;
  }

}