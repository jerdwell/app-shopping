<?php

namespace LoftonTi\Usersystem\Classes\UseCases\Products;

use Loftonti\Erso\Models\Products;

class GetProductUseCase
{
  /**
   * @var object
   */
  private $repository;
  
  /**
   * @var string
   */
  private $erso_code;

  /**
   * @param string $erso_code
   */
  public function __construct($erso_code) {
    $this -> erso_code = $erso_code;
    $this->repository = new Products;
  }

  public function getProduct(): object
  {
    try {
      $product = $this -> repository -> where('erso_code', $this -> erso_code)
        -> with([
          'brand',
          'branches',
          'category',
          'applications' => function($query_applications) {
            $query_applications -> with([
              'car',
              'shipowner',
            ]);
          }
        ])
        -> first();
      return $product;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}