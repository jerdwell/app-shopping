<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Usecase;

use LoftonTi\Apiv1\Services\Shoppings\Repositories\ShoppingEloquentRepository;

class GetOrdersOfMonthUseCase
{
  /**
   * @var int
   */
  private $branch_id;

  /**
   * @var object
   */
  private $repository;

  public function __construct($branch_id) {
    $this->branch_id = $branch_id;
    $this -> repository = new ShoppingEloquentRepository();
  }

  public function __invoke()
  {
    return $this -> repository -> getOrdersOfMonth($this -> branch_id);
  }
}