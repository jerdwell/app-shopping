<?php

namespace LoftonTi\Shoppings\Classes\UseCases;

use LoftonTi\Shoppings\Models\Shoppings;

class GetOrderUseCase
{

  /**
   * @var int
   */
  private $order_id, $user_id;

  /**
   * @var object
   */
  private $order;

  public function __construct(int $order_id, ?int $user_id) {
    $this->order_id = $order_id;
    $this->user_id = $user_id;
    $this -> order = Shoppings::find($this -> order_id);
    $this -> validOrder();
  }

  public function getOrderData()
  {
    try {
      $this -> order -> user;
      $this -> order -> products;
      $this -> order -> shopping_contact;
      return $this -> order;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function validOrder()
  {
    try {
      if(!$this -> order) throw new \Exception("Esta órden no existe o ha caducado.");
      if(!$this -> user_id && $this -> order -> user_id) throw new \Exception("Esta órden no existe o ha caducado.");
      if($this -> user_id != $this -> order -> user_id) throw new \Exception("Esta órden no existe o ha caducado.");
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}