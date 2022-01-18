<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Usecase;

use LoftonTi\Apiv1\Services\Products\UseCase\GetProductByIdUseCase;

class SetOrderItemsUseCase
{
  /**
   * @var int
   */
  private $branch_id;
  /**
   * @var array
   */
  private $items;
  /**
   * @var object
   */
  private $customer;
  
  public function __construct(array $items, int $branch_id, ?object $customer) {
    $this->branch_id = $branch_id;
    $this->items = $items;
    $this->customer = $customer;
  }

  public function __invoke():array
  {
    $items_quotation = [];
    foreach ($this -> items as $item) {
      $product = new GetProductByIdUseCase($item['id']);
      $product = $product();
      $stock = collect($product -> branches) -> firstWhere('id', $this -> branch_id) -> pivot -> stock;
      if (!$stock || $stock < $item['quantity']) throw new \Exception("El producto $product->product_name no cuenta con el stock necesario para esta compra");
      $price = SetPriceUseCase::price($product, $this -> customer);
      $items_quotation[] = [
        'product_id' => $product -> id,
        'quantity' => $item['quantity'],
        // 'product' => $product -> product_name,
        'discount' => 0.00,
        'current_price' => number_format($price, 2, '.', ''),
        // 'amount' => number_format(SetAmountUseCase::productAmount($price, $item['quantity']), 2, '.', ''),
        // 'marca' => $product -> brand -> brand_name,
        // 'image' => $product -> product_cover
      ];
    }
    return $items_quotation;
  }

}