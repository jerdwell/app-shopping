<?php
namespace LoftonTI\Usersystem\Classes\UseCases\Products;

use Loftonti\Erso\Models\Brands;

class SearchBrandsUseCase
{
  /**
   * @var string
   */
  private $data;

  /**
   * @var object
   */
  private $entity;

  public function __construct(string $param) {
    $this -> data = $param;
    $this -> validData();
    $this->entity = new Brands;
  }

  public function searchByParam(): Object
  {
    try {
      $brands = $this -> entity -> where('brand_name', 'like', "%$this->data%")
      -> get();
      return $brands;
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
      if(strlen(preg_replace('/\s+/', '', $this -> data)) < 1) throw new \Exception("El parámetro de búsqueda no puede estar vació ni contener menos de 2 caracteres.");
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}