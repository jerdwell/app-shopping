<?php

namespace Loftonti\Apiv1\Services\Billing\Repositories\FacturapiMethods;

trait CreateReceipt
{

  public function createReceipt(Array $items, String $payment, Int $folio):object
  {
    try {
      return $this -> repository -> Receipts -> create([
        "folio_number" => $folio,
        "payment_form" => $payment,
        "items" => $items
      ]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}