<?php

namespace LoftonTi\Usersystem\Classes\UseCases\Products;

use Loftonti\Erso\Models\Shipowners;

class CreateShipownerUseCase
{

  /**
   * @var string
   */
  private $shipowner_name;
  /**
   * @var object
   */
  private $entity;

  public function __construct(string $shipowner_name) {
    try {
      $this->shipowner_name = $shipowner_name;
      $this -> entity = new Shipowners;
      $this -> validShipowner();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function __invoke()
  {
    try {
      return $this -> entity -> create([
        'shipowner_name' => $this -> shipowner_name
      ]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Valid shipowner
   * @method
   */
  private function validShipowner(): void
  {
    try {
      if(strlen(preg_replace('/\s+/', '', $this -> shipowner_name)) <= 1) throw new \Exception("El nombre del auto no puede estar vacío.");
      $car = $this -> entity -> where('shipowner_name', $this -> shipowner_name)
        -> first();
      if($car) throw new \Exception("Este auto no puede darse de alta pues ya ha sido registrado.");
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}