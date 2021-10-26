<?php
namespace loftonTi\Usersystem\Classes\UseCases\Products;

use Loftonti\Erso\Models\CarsModels;

class CreateCarUseCase
{

  /**
   * @var string
   */
  private $car_name;
  /**
   * @var object
   */
  private $entity;

  public function __construct(string $car_name) {
    try {
      $this->car_name = $car_name;
      $this -> entity = new CarsModels;      
      $this -> validCarName();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function __invoke()
  {
    try {
      return $this -> entity -> create([
        'car_name' => $this -> car_name
      ]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function validCarName(): void
  {
    try {
      if(strlen(preg_replace('/\s+/', '', $this -> car_name)) <= 1) throw new \Exception("El nombre del auto no puede estar vacío.");
      $car = $this -> entity -> where('car_name', $this -> car_name)
        -> first();
      if($car) throw new \Exception("Este auto no puede darse de alta pues ya ha sido registrado.");
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}