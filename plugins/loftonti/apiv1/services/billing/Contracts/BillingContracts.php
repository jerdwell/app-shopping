<?php

namespace LoftonTi\Apiv1\Services\Billing\Contracts;

interface BillingContracts
{

  public function createInvoice(Array $customer, Array $items, String $payment, Int $folio, String $series): object;
  
  public function sendByEmail(String $id, Array $emails): void;
  
  public function createReceipt(Array $items, String $payment, Int $folio): object;

}