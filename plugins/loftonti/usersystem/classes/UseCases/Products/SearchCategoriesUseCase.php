<?php

namespace LoftonTi\Usersystem\Classes\UseCases\Products;

use Loftonti\Erso\Models\Categories;

class SearchCategoriesUseCase
{

  /**
   * @var string
   */
  private $data;
  /**
   * @var object
   */
  private $entity;

  public function __construct(String $data) {
    $this->data = $data;
    $this -> validData();
    $this -> entity = new Categories;
  }

  public function searchCategories(): object
  {
    try {
      return $this -> entity -> where('category_name', 'like', "%$this->data%")
        -> get();
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