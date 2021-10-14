<?php

namespace LoftonTi\Shoppings\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Shoppings\Classes\UseCases\CreateOrderUseCase;

class ShoppingApiController
{

  public function createOrder(Request $request)
  {
    try {
      if(!$request -> request -> has("type")) throw new \Exception("Es necesario especificar si será una cotización ó un pedido.");
      if(!$request -> request -> has("branch_id")) throw new \Exception("Es necesario especificar la sucursal donde se realizará la cotización/pedido.");
      if(!$request -> request -> has("items")) throw new \Exception("Los elementos para generar la cotización o pedido son requeridos.");
      if(!$request -> request -> has("shopping_contact")) throw new \Exception("La dirección de entrega es requerida cuando se realizará un pedido.");
      $use_case = new CreateOrderUseCase(
        $request -> data_user ? $request -> data_user['id'] : null, 
        $request -> type, 
        $request -> items,
        $request -> shopping_contact,
        $request -> branch_id);
      return $use_case();
    } catch (\Throwable $th) {
      return response()
        -> json([
          'error' => $th -> getMessage()
        ], 400);
    }
  }

}