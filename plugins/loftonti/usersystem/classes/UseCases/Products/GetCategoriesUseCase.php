<?php

namespace LoftonTi\Usersystem\Classes\UseCases\Products;
use Loftonti\Erso\Models\Categories as CategoriesModel;

class GetCategoriesUseCase
{
  
  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this -> repository = new CategoriesModel();
  }

  public function __invoke():object
  {
    try {
      return $this -> repository 
        -> orderBy('category_name', 'asc')
        -> get();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}