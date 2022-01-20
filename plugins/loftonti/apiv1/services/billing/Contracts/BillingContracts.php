<?php

namespace LoftonTi\Apiv1\Services\Billing\Contracts;

interface BillingContracts
{

  public function createBilling(array $shopping): object;

}