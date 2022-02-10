<?php

namespace LoftonTi\Apiv1\Services\Billing\UseCase;

use LoftonTi\Apiv1\Services\Billing\Repositories\BillingFacturapiRepository;

class GetInvoiceUseCase
{

  /**
   * @var string
   */
  private $id;
  /**
   * @var object
   */
  private $repository;

  public function __construct(string $id) {
    $this->id = $id;
    $this->repository = new BillingFacturapiRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> getInvoice($this -> id);
  }

}