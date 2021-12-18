<?php

namespace LoftonTi\Apiv1\Services\Cars\Contracts;

interface CarContract
{

  public function searchCars(string $param): object;

  public function getByCarName(string $param): ?object;

}