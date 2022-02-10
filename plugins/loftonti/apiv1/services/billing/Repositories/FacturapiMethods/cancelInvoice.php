<?php

namespace LoftonTi\Apiv1\Services\Billing\Repositories\FacturapiMethods;

trait cancelInvoice
{

  public function cancelInvoice(string $id, ?string $motive): ?object
  {
    return $this -> repository -> Invoices -> cancel($id, [
      'motive' => $motive
    ]);
  }

}