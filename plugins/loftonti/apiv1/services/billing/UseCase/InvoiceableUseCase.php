<?php

namespace LoftonTi\Apiv1\Services\Billing\UseCase;

use LoftonTi\Apiv1\Services\Billing\UseCase\CreateInvoiceUseCase;
use Loftonti\Apiv1\Services\Billing\UseCase\SendByEmailInvoiceUseCase;

class InvoiceableUseCase
{

  public function handler(object $order, string $type_billing): object
  {
    $method  = [
      'invoice' => new CreateInvoiceUseCase($order),
      'receipt' => new CreateReceiptUseCase($order, null),
    ];
    $event = $method[$type_billing]();
    if ($type_billing === 'invoice') {
      $sended = new SendByEmailInvoiceUseCase($event -> id, [$order -> shopping_contact]);
      $sended();
    }
    return $event;
  }

}