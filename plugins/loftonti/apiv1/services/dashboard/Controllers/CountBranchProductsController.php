<?php

namespace LoftonTi\Apiv1\Services\Dashboard\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Apiv1\Services\Products\UseCase\CountProductsActiveOfBranchUseCase;
use Loftonti\Apiv1\Services\Products\UseCase\ProductsMostSelledofBranchUseCase;
use LoftonTi\Apiv1\Services\Shoppings\Usecase\GetOrdersOfMonthUseCase;

class CountBranchProductsController
{

  /**
   * Get count of active products of branch
   * @param int $branch_id
   */
  public function __invoke(Request $request)
  {
    try {
      $all_products = new CountProductsActiveOfBranchUseCase($request -> branch_id);
      $products_most_selled = new ProductsMostSelledofBranchUseCase($request -> branch_id);
      $order_of_the_month = new GetOrdersOfMonthUseCase($request -> branch_id);
      return [
        'branch_id' => $request -> branch_id,
        'all_products' => $all_products() -> all_products,
        'orders_of_the_month' => $order_of_the_month() -> shoppings,
        'products_most_selled' => $products_most_selled()
      ];
    } catch (\Throwable $th) {
      return response()
        -> json(['error' => $th -> getMessage()], 400);
    }
  }

}