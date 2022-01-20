<?php

namespace LoftonTi\Apiv1\Services\Billing\UseCase;

use LoftonTi\Apiv1\Services\Billing\Repositories\BillingFacturapiRepository;

class CreateInvoiceUseCase
{
  /**
   * @var object
   */
  private $repository, $order;

  /**
   * @param object $customer order data
   * @return object check all items to get by invoice on https://docs.facturapi.io/api/#operation/createInvoice
   */
  public function __construct(object $order) {
    $this->repository = new BillingFacturapiRepository;
    $this -> order = $order;
  }

  public function __invoke()
  {
    try {
      $customer = [
        "legal_name" => $this -> order -> shopping_contact -> fullname,
        "email" => $this -> order -> shopping_contact -> email,
        "tax_id" => "mone890912qi2"
      ];
      $items = SetItemsInvoiceUseCase::setItems($this -> order -> products);
      $payment_form = 'efectivo';
      $folio = $this -> order -> id;
      $series = "F";
      $invoice = $this -> repository -> createInvoice($customer, $items, $payment_form, $folio, $series);    if (isset($invoice -> message)) throw new \Exception($invoice -> message);
      if (isset($invoice -> message)) throw new \Exception($invoice -> message);
      return $invoice;
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  
}
