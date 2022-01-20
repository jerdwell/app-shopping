<?php

namespace LoftonTi\Apiv1\Services\Billing\Repositories\FacturapiMethods;

trait sendByEmail
{

  public function sendByEmail(String $id, Array $emails): void
  {
    $this -> repository -> Invoices -> send_by_email($id, $emails);
  }

}