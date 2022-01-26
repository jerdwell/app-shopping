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

  public function list(string $begin, string $end, string $order, ?int $branch_id, ?int $customer_id, int $limit): object
  {
    return $this -> repository 
      -> whereDate('created_at', '>=', now() -> parse($begin) -> format('Y-m-d H:i:s'))
      -> whereDate('created_at', '<=', now() -> parse($end) -> format('Y-m-d H:i:s'))
      -> when($branch_id, function($q) use ($branch_id) {
        $q -> whereHas('branch', function($b) use ($branch_id){
          $b -> where('branch_id', $branch_id);
        });
      })
      -> when($customer_id, function($q) use ($customer_id) {
        $q -> whereHas('user', function($b) use ($customer_id){
          $b -> where('user_id', $customer_id);
        });
      })
      -> with([
        'user',
        'shopping_contact',
        'products'
      ])
      -> orderBy('id', 'desc')
      -> paginate($limit);
  }

  public function find(int $id): ?object
  {
    return $this -> repository 
      -> with([
        'products',
        'user',
        'branch'
      ]) 
      -> find($id);
  }

  public function updateStatus(int $id, string $status, ?string $notes): bool
  {
    return $this -> repository 
      -> where('id', $id)
      -> update(['status' => $status, 'notes' => $notes]); 
  }

}