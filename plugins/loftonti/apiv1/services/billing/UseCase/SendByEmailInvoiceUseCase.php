<?php

namespace Loftonti\Apiv1\Services\Billing\UseCase;

use LoftonTi\Apiv1\Services\Billing\Repositories\BillingFacturapiRepository;

class SendByEmailInvoiceUseCase
{
  /**
   * @var string
   */
  private $id;
  /**
   * @var object
   */
  private $repository;

  /**
   * Send invoice by email max 10 emails
   * @param string $id invoice id
   * @param array $emails list of emails to send invoice
   */
  public function __construct(String $id) {
    $this->id = $id;
    $this -> repository = new BillingFacturapiRepository;
  }

  public function __invoke(): void
  {
    $this -> repository -> sendByEmail($this -> id);
  }

}