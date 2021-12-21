<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase;

use Loftonti\Apiv1\Services\Products\Repositories\ProductEloquentRepository;

class GetProductsInErsoCodesUseCase
{
  /**
   * @var array
   */
  private $codes;
  
  /**
   * @var object
   */
  private $repository;

  public function __construct(array $codes) {
    $this->codes = $codes;
    $this -> repository = new ProductEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> getInErsoCode($this -> codes);
  }
}