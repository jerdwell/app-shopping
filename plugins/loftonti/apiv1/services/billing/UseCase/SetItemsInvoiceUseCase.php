<?php

namespace LoftonTi\Apiv1\Services\Billing\UseCase;

class SetItemsInvoiceUseCase
{

  public static function setItems(object $products): array
  {
    try {
      $items = [];
      foreach ($products as $item) {
        $items[] = [
          "quantity" => $item -> pivot -> quantity,
          "discount" => $item -> pivot -> discount,
          "product" => [
            "description" => $item -> product_name,
            "product_key" => "25171714",
            "price" => $item -> pivot -> current_price,
            "sku" => $item -> erso_code,
          ]
        ];
      }
      return $items;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}