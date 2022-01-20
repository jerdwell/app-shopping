<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Usecase;

use LoftonTi\Apiv1\Services\Shoppings\Repositories\ShoppingEloquentRepository;

class GetShoppingUseCase
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
    $this -> repository = new ShoppingEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> find($this -> id);
  }

}