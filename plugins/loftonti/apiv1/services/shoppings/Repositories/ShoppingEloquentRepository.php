<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Repositories;

use Loftonti\Apiv1\Services\Shoppings\Contracts\ShoppingsContracts;
use LoftonTi\Shoppings\Models\Shoppings;

class ShoppingEloquentRepository implements ShoppingsContracts
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new Shoppings;
  }

  public function getOrdersOfMonth(int $branch_id): object
  {
    $orders = $this -> repository
      -> selectRaw('count(id) as shoppings')
      -> whereRaw('YEAR(updated_at) = YEAR(CURRENT_DATE())')
      -> whereRaw('MONTH(updated_at) = MONTH(CURRENT_DATE())')
      -> where('status', 'shipped')
      -> first();
    return $orders;
  }

}