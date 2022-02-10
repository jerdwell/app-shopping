<?php

namespace LoftonTi\Apiv1\Services\Billing\UseCase;

use LoftonTi\Apiv1\services\Billing\UseCase\CancelInvoiceUseCase;

class CancelBilleableUseCase
{

  public function handler(object $order, string $motive)
  {
    try {
      if ($order -> type_billing === 'invoice')
      {
        $cancel_invoice = new CancelInvoiceUseCase($order -> billing_id, $motive);
        $cancel_invoice();
      } else {
        $cancel_receipt = new CancelReceiptUseCase($order -> billing_id);
        $cancel_receipt();
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}