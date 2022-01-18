<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Repositories;

use Illuminate\Support\Facades\DB;
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

  public function create(array $order_data, array $items, array $shopping_contact): object
  {
    return DB::transaction(function() use ($order_data, $items, $shopping_contact) {
      $order = $this -> repository -> create($order_data);
      $order -> shopping_contact() -> create($shopping_contact);
      $order -> products() -> attach($items);
      return $order;
    });
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