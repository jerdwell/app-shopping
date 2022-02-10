<?php

namespace LoftonTi\Apiv1\Services\Billing\Repositories\FacturapiMethods;

trait getInvoice
{

  public function getInvoice(string $id): ?object
  {
    return $this -> repository -> Invoices -> retrieve($id);
  }

}