<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Usecase;

use LoftonTi\Apiv1\Services\Shoppings\Repositories\ShoppingEloquentRepository;

class CreateOrderUseCase
{
  /**
   * @var array
   */
  private $items, $shopping_contact;
  /**
   * @var null|int
   */
  private $customer_id;
  
  /**
   * @var int
   */
  private $branch_id;
  /**
   * @var object
   */
  private $repository;

  public function __construct(array $items, ?object $customer, int $branch_id, array $shopping_contact) {
    $this -> customer_id = isset($customer -> id) ? $customer -> id : null;
    $this -> branch_id = $branch_id;
    $this -> shopping_contact = $shopping_contact;
    $this->items = $items;
    $this -> repository = new ShoppingEloquentRepository;
  }

  public function __invoke()
  {
    $amount = SetAmountUseCase::orderAmount($this -> items);
    $order_data = [
      'amount' => number_format($amount, 2, '.', ''),
      'branch_id' => $this -> branch_id,
      'discount' => 0.00,
      'status' => 'standby',
      'shipping_cost' => 0.00,
      'user_id' => $this -> customer_id
    ];
    return $this -> repository 
      -> create($order_data, $this -> items, $this -> shopping_contact);
  }

}