<?php

namespace LoftonTi\Apiv1\Services\Billing\Repositories\FacturapiMethods;

trait cancelReceipt
{

  public function cancelReceipt(string $id): object
  {
    return $this -> repository -> Receipts -> cancel($id);
  }

}