<?php

namespace LoftonTi\Apiv1\Services\Billing\Repositories;

use Facturapi\Facturapi;
use LoftonTi\Apiv1\Services\Billing\Contracts\BillingContracts;
use LoftonTi\Apiv1\Services\Billing\Repositories\FacturapiMethods\createInvoice;
use Loftonti\Apiv1\Services\Billing\Repositories\FacturapiMethods\CreateReceipt;
use LoftonTi\Apiv1\Services\Billing\Repositories\FacturapiMethods\sendByEmail;

class BillingFacturapiRepository implements BillingContracts
{
  use 
    createInvoice,
    sendByEmail,
    CreateReceipt;
  /**
   * @var string
   */
  private $secret_key;

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this -> secret_key = getenv('FACTURAPI_SECRET_KEY');
    $this->repository = new Facturapi($this -> secret_key);
  }

  // trait in createBilling
  // public function createBilling(array $data): object;

}