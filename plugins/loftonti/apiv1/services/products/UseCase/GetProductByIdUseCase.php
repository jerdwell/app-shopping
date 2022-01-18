<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase;

use Loftonti\Apiv1\Services\Products\Repositories\ProductEloquentRepository;

class GetProductByIdUseCase
{
  /**
   * @var int
   */
  private $id;
  /**
   * @var object
   */
  private $repository;

  public function __construct(int $id) {
    $this->id = $id;
    $this -> repository = new ProductEloquentRepository;
  }

  public function __invoke(): ?object
  {
    return $this -> repository -> getById($this -> id);
  }

}