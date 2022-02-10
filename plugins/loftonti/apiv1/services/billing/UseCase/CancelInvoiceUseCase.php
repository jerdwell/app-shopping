<?php

namespace LoftonTi\Apiv1\services\Billing\UseCase;

use LoftonTi\Apiv1\Services\Billing\Repositories\BillingFacturapiRepository;

class CancelInvoiceUseCase
{
  /**
   * @var int
   */
  private $id, $motive;
  /**
   * @var object
   */
  private $repository;

  public function __construct(string $id, ?string $motive) {
    $this->id = $id;
    $this->motive = $motive;
    $this -> repository = new BillingFacturapiRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> cancelInvoice($this -> id, $this -> motive);
  }

}