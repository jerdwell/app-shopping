<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use LoftonTi\Apiv1\Services\Broadcast\Repository\BroadcastRepository;
use LoftonTi\Apiv1\Services\Customers\Usecase\GetCustomerByColUseCase;
use LoftonTi\Apiv1\Services\Shoppings\Requests\CreateShoppingrequest;
use LoftonTi\Apiv1\Services\Shoppings\Usecase\CreateOrderUseCase;
use LoftonTi\Apiv1\Services\Shoppings\Usecase\SetOrderItemsUseCase;

class CreateShoppingController
{

  public function __invoke(Request $request)
  {
    try {
      $validation = new CreateShoppingrequest;
      $validation($request);
      $customer = new GetCustomerByColUseCase;
      if ($request -> customer_id) $customer = $request -> customer_id ? $customer('id', $request -> customer_id) : null;
      $items = new SetOrderItemsUseCase($request -> items, $request -> branch_id, $customer);
      $items = $items();
      $order = new CreateOrderUseCase($items, $customer, $request -> branch_id, $request -> shopping_contact, $request -> notes);
      $order = $order();
      Queue::push('LoftonTi\Apiv1\Services\Shoppings\Events\OrderCreatedEvent', [
        'order_id' => $order -> id,
        'branch_id' => $order -> branch_id
      ]);
      return $order;
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}