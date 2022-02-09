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
   * @var null|string
   */
  private $notes, $payment_method, $type_billing, $billing_id, $case_shopping;
  /**
   * @var bool
   */
  private $sold_out;
  
  /**
   * @var int
   */
  private $branch_id;
  /**
   * @var object
   */
  private $repository;

  public function __construct(array $items, ?object $customer, int $branch_id, array $shopping_contact, ?string $notes, bool $sold_out, string $payment_method, string $type_billing, string $case_shopping, ?string $billing_id) {
    $this -> customer_id = isset($customer -> id) ? $customer -> id : null;
    $this -> branch_id = $branch_id;
    $this -> shopping_contact = $shopping_contact;
    $this->items = $items;
    $this -> notes = $notes;
    $this -> sold_out = $sold_out;
    $this -> payment_method = $payment_method;
    $this -> type_billing = $type_billing;
    $this -> case_shopping = $case_shopping;
    $this -> billing_id = $billing_id;
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
      'notes' => $this -> notes,
      'user_id' => $this -> customer_id,
      'sold_out' => $this -> sold_out,
      'payment_method' => $this -> payment_method,
      'type_billing' => $this -> type_billing,
      'case_shopping' => $this -> case_shopping,
      'billing_id' => $this -> billing_id
    ];
    return $this -> repository 
      -> create($order_data, $this -> items, $this -> shopping_contact);
  }

}