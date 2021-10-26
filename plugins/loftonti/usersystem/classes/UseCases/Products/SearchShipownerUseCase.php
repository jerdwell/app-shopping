<?php

namespace LoftonTI\Usersystem\Classes\UseCases\Products;

use Loftonti\Erso\Models\Shipowners;

class SearchShipownerUseCase
{

  /**
   * @var string
   */
  private $data;
  /**
   * @var object
   */
  private $entity;

  public function __construct(string $data) {
    $this->data = $data;
    $this -> validData();
    $this -> entity = new Shipowners;
  }

  public function searchByParam()
  {
    try {
      $shipowners = $this -> entity -> where('shipowner_name', 'like', "%$this->data%")
        -> get();
      return $shipowners;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Valid if data contains with all parameters to send event
   * @method
   */
  private function validData()
  {
    try {
      if(strlen(preg_replace('/\s+/', '', $this -> data)) < 2) throw new \Exception("El parámetro de búsqueda no puede estar vació ni contener menos de 2 caracteres.");
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}