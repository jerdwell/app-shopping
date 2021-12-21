<?php

namespace Loftonti\Apiv1\Services\Brands\UseCase;

use LoftonTi\Apiv1\Services\Brands\Repositories\BrandEloquentRepository;

class SearchBrandUseCase
{
  /**
   * @var string
   */
  private $param;

  /**
   * @var object
   */
  private $repository;

  public function __construct(string $param) {
    $this->param = $param;
    $this->repository = new BrandEloquentRepository;
  }

  public function __invoke()
  {
    return $this 
      -> repository 
      -> search($this -> param);
  }

}