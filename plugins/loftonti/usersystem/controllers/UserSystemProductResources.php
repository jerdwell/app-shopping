<?php 
namespace LoftonTI\Usersystem\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use LoftonTi\Usersystem\Classes\UseCases\Branches\AttachProductUseCase;
use LoftonTI\Usersystem\Classes\UseCases\Products\CreateProductUseCase;
use LoftonTi\Usersystem\Classes\UseCases\Products\GetProductUseCase;

class UserSystemProductResources
{
  /**
   * @var string
   */
  private $public_price, $customer_price;
  /**
   * @var array
   */
  private
    $items,
    $cars, 
    $shipowners, 
    $brands,
    $categories, 
    $applications;

  public function createProductController(Request $request)
  {
    try {
      if (count($request -> items) > 20) {
        Queue::push('LoftonTi\Usersystem\Classes\UseCases\Products\CreateProductsQueueUseCase', [
          'items' => $request -> items,
          'branch_id' => $request -> branch_id,
          'user_id' => $request -> user_id,
        ]);
        return [
          'queue' => true,
          'status' => 'working',
          'errors' => [],
          'assertions' => 0
        ];
      }else{
        $use_case = new CreateProductUseCase($request -> items, $request -> branch_id);
        $createds = $use_case();
        return [
          'queue' => false,
          'status' => 'finish',
          'errors' => $createds['errors'],
          'assertions' => $createds['assertions'],
          'items' => $createds['items']
        ];
      }
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ]);
    }
  }

  /**
   * get all data of product finded by erso_code
   * @method getProductController
   * @param string $erso_code
   */
  public function getProductController($erso_code)
  {
    try {
      $use_case = new GetProductUseCase($erso_code);
      return $use_case -> getProduct();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}