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
        "tax_id" => $this -> order -> shopping_contact -> rfc
      ];
      $items = SetItemsInvoiceUseCase::setItems($this -> order -> products);
      $folio = $this -> order -> id;
      $series = null;
      $invoice = $this -> repository -> createInvoice(
        $customer,
        $items,
        $this -> order -> payment_method,
        $folio,
        $series
      );
      if (isset($invoice -> message)) throw new \Exception($invoice -> message);
      return $invoice;
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  
}
