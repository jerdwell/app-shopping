<?php
namespace LoftonTi\Usersystem\Classes\UseCases\Products;

use Loftonti\Erso\Models\CarsModels;

class GetCarsUseCase
{

  /**
   * @var object
   */
  private $entity;

  public function __construct() {
    $this->entity = new CarsModels;
  }

  public function get():object
  {
    try {
      return $this -> entity 
        -> orderBy('car_name', 'asc')
        -> get();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}