<?php

namespace LoftonTi\Apiv1\Services\Billing\UseCase;

use LoftonTi\Apiv1\Services\Billing\UseCase\CreateInvoiceUseCase;
use Loftonti\Apiv1\Services\Billing\UseCase\SendByEmailInvoiceUseCase;

class InvoiceableUseCase
{

  public function handler(object $order, bool $invoiceable)
  {
    $invoiceable = $invoiceable ? 'invoice' : 'receipt';
    $method  = [
      'invoice' => new CreateInvoiceUseCase($order),
      'receipt' => new CreateReceiptUseCase($order, null),
    ];
    $event = $method[$invoiceable]();
    if ($invoiceable === 'invoice') {
      $sended = new SendByEmailInvoiceUseCase($event -> id, [$order -> shopping_contact]);
      $sended();
    }
  }

}