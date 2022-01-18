<?php

namespace LoftonTi\Apiv1\Services\Applications\Contracts;

interface ApplicationsContracts
{

  public function getRangeYears(?int $car, ?int $shipowner): object;

}