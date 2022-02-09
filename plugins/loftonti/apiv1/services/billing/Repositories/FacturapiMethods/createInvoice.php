<?php

namespace LoftonTi\Apiv1\Services\Billing\Repositories\FacturapiMethods;

trait createInvoice
{

  public function createInvoice(Array $customer, Array $items, String $payment, Int $folio, ?String $series): object
  {
    $payment_form = [
      'cash' => \Facturapi\PaymentForm::EFECTIVO,
      'transfer' => \Facturapi\PaymentForm::TRANSFERENCIA_ELECTRONICA,
      'credit_card' => \Facturapi\PaymentForm::TARJETA_DE_CREDITO,
      'debit_card' => \Facturapi\PaymentForm::TARJETA_DE_DEBITO,
    ];
    $invoice = $this -> repository->Invoices->create([
      "customer" => $customer,
      "items" => $items,
      "payment_form" => $payment_form[$payment],
      "folio_number" => $folio,
      "series" => $series
    ]);
    
    return $invoice;
  }

}