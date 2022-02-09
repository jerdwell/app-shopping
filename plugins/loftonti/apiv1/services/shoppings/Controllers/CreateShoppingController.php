<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use LoftonTi\Apiv1\Services\Billing\UseCase\InvoiceableUseCase;
use LoftonTi\Apiv1\Services\Customers\Usecase\GetCustomerByColUseCase;
use LoftonTi\Apiv1\Services\Shoppings\Requests\CreateShoppingrequest;
use LoftonTi\Apiv1\Services\Shoppings\Usecase\CreateOrderUseCase;
use LoftonTi\Apiv1\Services\Shoppings\Usecase\GetShoppingUseCase;
use LoftonTi\Apiv1\Services\Shoppings\Usecase\SetOrderItemsUseCase;
use LoftonTi\Apiv1\Services\Shoppings\Usecase\SubstractItemsFromStockUseCase;
use LoftonTi\Apiv1\Services\Shoppings\UseCase\UpdateOrderStatusUseCase;

class CreateShoppingController
{

  public function __invoke(Request $request)
  {
    try {
      $validation = new CreateShoppingrequest;
      $validation($request);
      
      $customer = new GetCustomerByColUseCase;
      
      if ($request -> customer_id) $customer = $request -> customer_id ? $customer('id', $request -> customer_id) : null;
      if (!$request -> customer_id) $customer = null;
      
      $items = new SetOrderItemsUseCase($request -> items, $request -> branch_id, $customer);
      $items = $items();
      
      $order = new CreateOrderUseCase(
        $items,
        $customer,
        $request -> branch_id,
        $request -> shopping_contact,
        $request -> notes,
        $request -> sold_out,
        $request -> payment_method,
        $request -> type_billing,
        $request -> case_shopping,
        null);
        
      $order = $order();
      
      $update_stock = new SubstractItemsFromStockUseCase(new GetShoppingUseCase($order -> id));
      $update_stock();

      try {
        $invoice_handler = new InvoiceableUseCase();
        $billing = $invoice_handler -> handler($order, $request -> type_billing);
      } catch (\Throwable $th) {
        $cancel_order = new UpdateOrderStatusUseCase($order -> id, 'cancelled', 'Datos de facturación incorrectos.');
        $cancel_order();
        throw new \Exception('Lo sentimos, no se ha podido generar la factura: ' . $th -> getMessage());
      }

      $order -> update(['billing_id' => $billing -> id]);

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