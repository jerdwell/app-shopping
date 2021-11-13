<?php

namespace LoftonTi\Usersystem\Classes\UseCases\Products;

use Loftonti\Erso\Models\Shipowners;

class GetShipownersUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this -> repository = new Shipowners;
  }

  public function get()
  {
    try {
      return $this -> repository -> get();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}