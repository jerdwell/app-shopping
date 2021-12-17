<?php

namespace LoftonTi\Apiv1\Services\Cars\Contracts;

interface CarContract
{

  public function searchCars(string $param): Object;

}