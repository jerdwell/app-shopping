<?php 
namespace LoftonTI\Usersystem\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Loftonti\Erso\Models\Branches;
use Loftonti\Erso\Models\Products;
use LoftonTi\Usersystem\Classes\UseCases\Branches\AttachProductUseCase;
use LoftonTI\Usersystem\Classes\UseCases\Products\CreateProductUseCase;
use LoftonTi\Usersystem\Classes\UseCases\Products\GetProductUseCase;
use LoftonTI\Usersystem\Classes\UseCases\Products\UpdateProductUseCase;

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
      return response() -> json([
        'error' => $th -> getMessage()
      ], 401);
    }
  }

  /**
   * Upload or update product image
   * @method uploadProduct
   */
  public function uploadProduct(Request $request)
  {
    try {
      $image = $request -> file('product-image');
      if(!$image) throw new \Exception("No existe un archivo para cargar");
      if(!in_array($image -> getMimeType(), ['image/png', 'image/jpg', 'image/jpeg'])) throw new \Exception("El tipo de imagen solo puede ser jpeg, jpg o png");
      if($image -> getSize() > 2000000) throw new \Exception("la imágen no debe exceder los 2MB.");
      Storage::putFileAs('media/products', $request -> file('product-image'), $request -> erso_code . '.jpg');
      return response() -> json([
        'message' => 'Imágen subida exitosamente.'
      ], 201);
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 403);
    }
  }

  /**
   * Upload product api
   * @method updateProductController
   * @param Object $request
   */
  public function updateProductController(Request $request)
  {
    try {
      $use_case = new UpdateProductUseCase(
        $request -> erso_code, 
        $request -> product, 
        $request -> branch_id);
      return $use_case();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 403);
    }
  }

  /**
   * get all products from branch only with category
   * @method getAllSingleProductsForBranch
   */
  public function getAllProductsForBranch(Request $request)
  {
    try {
      $paginate = in_array($request -> per_page, [50, 100, 200, 500]) ? $request -> per_page : 50;
      $branch = Branches::where('id', $request -> branch_id) -> first();
      $branch -> setRelation('products', $branch -> products()
        -> with('category')
        -> when($request -> order_by && $request -> order, function($q) use($request) {
            $items_valid = ['id', 'erso_code', 'product_name', 'public_price', 'customer_price'];
            if(!in_array($request -> order_by, $items_valid) || !in_array($request -> order, ['asc', 'desc'])) return;
            $q -> orderBy($request->order_by, $request->order);
          })
        -> when($request -> param, function ($query_search) use($request){
          $query_search -> where('erso_code', 'like', "%$request->param%");
        })
        -> paginate($paginate));
      return $branch;
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 403);
    }
  }

}