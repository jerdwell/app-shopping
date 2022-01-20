<?php

namespace LoftonTi\Apiv1\Services\Billing\UseCase;

use LoftonTi\Apiv1\Services\Billing\Repositories\BillingFacturapiRepository;

class CreateReceiptUseCase
{
  /**
   * @var object
   */
  private $repository, $order;

  /**
   * @param null|string $payment
   * @param object $order order data to create receipt
   * @return object check all items to get by invoice on https://docs.facturapi.io/api/#operation/createInvoice
   */
  public function __construct(object $order, ?string $payment) {
    $this -> order = $order;
    $this -> payment = $payment ? $payment : "03";
    $this->repository = new BillingFacturapiRepository;
  }

  public function __invoke(): object
  {
    try {
      $folio = $this -> order -> id;
      $items = SetItemsInvoiceUseCase::setItems($this -> order -> products);
      $receipt = $this 
        -> repository
        -> createReceipt($items, $this -> payment, $folio);
      if (isset($receipt -> message)) throw new \Exception($receipt -> message);
      return $receipt;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}