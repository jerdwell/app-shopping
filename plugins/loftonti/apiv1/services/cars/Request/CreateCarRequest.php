<?php

namespace LoftonTi\Apiv1\Services\Cars\Request;

use LoftonTi\Apiv1\Services\Cars\Usecase\GetCarByNameUseCase;

trait CreateCarRequest
{

  public function valid(string $car_name)
  {
    try {
      if(strlen(preg_replace('/\s+/', '', $car_name)) <= 1) throw new \Exception("El nombre del auto no puede estar vacío.");
      $car = new GetCarByNameUseCase;
      $car = $car($car_name);
      if($car) throw new \Exception("Este auto no puede darse de alta pues ya ha sido registrado.");
    } catch (\Throwable $th) {
      throw $th;
    }    
  }

}