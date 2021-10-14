<?php

namespace LoftonTi\Shoppings\Classes\UseCases;

use Illuminate\Support\Facades\DB;
use LoftonTi\Shoppings\Classes\Validations\ValidateShoppingContact;
use LoftonTi\Shoppings\Classes\Validations\ValidProductsQuotation;
use LoftonTi\Shoppings\Models\Shoppings;
use LoftonTi\Users\Models\Users;

class CreateOrderUseCase
{

  /**
   * @var null|int
   */
  private $user_id, $branch_id;
  /**
   * @var string
   */
  private $type, $user_type;
  /**
   * @var double
   */
  private $amount = 0.00;
  private $shipping_cost = 0.00;
  private $discount = 0.00;

  /**
   * @var array
   */
  private $items, $shopping_contact, $items_quotation;

  /**
   * @var object
   */
  private $products;

  public function __construct(?int $user_id, string $type, array $items, array $shopping_contact, int $branch_id) {
    $this->user_id = $user_id;
    $this->branch_id = $branch_id;
    $this->type = $type;
    $this->items = $items;
    $this->shopping_contact = $shopping_contact;

    $valid_items = new ValidProductsQuotation($items, $branch_id);
    $this -> products = $valid_items -> getProducts();
    if($this -> type == 'order') new ValidateShoppingContact($shopping_contact);
  }

  public function __invoke()
  {
    try {
      $this -> setUsertype();
      $this -> prepareOrderItems();
      $this -> setAmount();
      return $this -> createOrder();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function createOrder()
  {
    try {
      $items = collect($this -> items_quotation) -> map(function($q){
        return [
          'product_id' => $q['product_id'], 
          'current_price' => $q['current_price'], 
          'discount' => $q['discount'], 
          'quantity' => $q['quantity']
        ];
      }) -> all();
      $order = DB::transaction(function() use($items){
        $order = Shoppings::create($this -> getOrderData());
        $order -> shopping_contact() -> create($this -> shopping_contact);
        $order -> products() -> attach($items);
        return $order;
      });
      return $order;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getOrderData()
  {
    try {
      return [
        'amount' => $this -> amount,
        'discount' => 0.00,
        'status' => 'standby',
        'shipping_cost' => 0.00,
        'branch_id' => $this -> branch_id,
        'user_id' => $this -> user_id
      ];
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function prepareOrderItems()
  {
    try {
      $items_quotation = [];
      foreach ($this -> items as $item) {
        $product = collect($this -> products)
          -> firstWhere('id', $item['id']);
        $price = $this -> user_id && $this -> user_type == 'customer' ? $product['customer_price'] : $product['public_price'];
        $items_quotation[] = [
          'product_id' => $item['id'],
          'quantity' => $item['quantity'],
          'product' => $item['product_name'],
          'discount' => 0.00,
          'current_price' => number_format($price, 2, '.', ''),
          'amount' => $this -> calcPrice($item['quantity'], $price),
          'marca' => $product['brand']['brand_name'],
          'image' => $product['product_cover']
        ];
      }
      $this -> items_quotation = $items_quotation;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function calcPrice($quantity, $price): string
  {
    $amount = $quantity * $price;
    $this -> amount += $amount;
    return $amount;
  }

  private function setAmount()
  {
    $this -> amount = number_format(($this -> amount - $this -> discount) + $this -> shipping_cost, 2, '.', '');
  }

  private function setUsertype()
  {
    try {
      if(!$this -> user_id) return false;
      $user = Users::find($this -> user_id);
      $this -> user_type = $user -> type;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}