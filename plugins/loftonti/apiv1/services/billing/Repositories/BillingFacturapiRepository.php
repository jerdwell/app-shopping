<?php

namespace LoftonTi\Apiv1\Services\Billing\Repositories;

use LoftonTi\Apiv1\Services\Billing\Contracts\BillingContracts;

class BillingFacturapiRepository implements BillingContracts
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new Facturapi('ok');
  }

  public function createBilling(array $data): object
  {
    return $this -> repository;
  }

}