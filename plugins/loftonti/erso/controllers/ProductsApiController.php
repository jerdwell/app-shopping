<?php namespace Loftonti\Erso\Controllers;

use Illuminate\Routing\Controller;
use Loftonti\Erso\Models\{ Shipowners, Products, Categories, CarsModels, ErsoCodes, Brands };
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class ProductsApiController extends Controller {

  public function serachCarsModels($car)
  {
    $car = Str::slug($car);
    $shipowners = Shipowners::getCarModels($car) -> groupBy('model_id') -> get();
    return $shipowners;
  }

  public function searchCars($branch, $model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null)
  {
    $products = Products::filterCars(
      $branch, $model, $shipowner, $filter1, $value1, $filter2, $value2
    )->paginate(20);
    
    $years = Products::filterYear(
      $branch,$model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null
      )->get();

    $categories = Products::filterCategories(
      $model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null, $branch
    )
    ->with(['category'])
    ->get();

    // $products -> push(['years' => $years]);
    return [
      'products' => $products,
      'years' => $years,
      'categories' => $categories
    ];
    
  }

  public function SearchProductCategoryModel($model, $category)
  {
    $category = Categories::where('category_slug', $category)->first();
    if(empty($category)) return response(['Categoría no encontrada'], 404);
    $products = Products::where('model_id', $model)
      -> where('category_id', $category->id)->get();
    return $products;
  }

  public function GeneralSearchProduct($data)
  {
    try {
      $shipowners = Shipowners::selectRaw('group_concat(id separator ",") as shipowners') -> where('shipowner_slug', 'like', "%{$data}%") -> first();
      $models = CarsModels::selectRaw('group_concat(id separator ",") as models') -> where('model_slug', 'like', "%{$data}%") -> first();
      $brands = Brands::selectRaw('group_concat(id separator ",") as brands') -> where('brand_name', 'like', "%{$data}%") -> first();
      $shipowners = explode(',', $shipowners-> shipowners);
      $models = explode(',', $models-> models);
      $brands = explode(',', $brands-> brands);
      $products = Products::where('product_name', 'like', "%{$data}%")
        -> when(!empty($shipowners), function($q) use($shipowners){
          return $q -> orWhereIn('shipowner_id', $shipowners);
        })
        ->when(!empty($models), function($q) use($models){
          return $q->orWhereIn('model_id',$models);
        })
        ->when(!empty($brands), function($q) use($brands){
          return $q->orWhereIn('brand_id',$brands);
        })
        ->with([ 'car', 'shipowner', 'brand' ])
        ->orderBy('category_id')
        ->paginate(20);
      return ['products' => $products];
    } catch (\Throwable $th) {
      print_r($th -> getMessage());
      return response(['Error, datos no localizados', 503]);
    }
  }

  public function CodeSearchProduct($data)
  {
    $codes = ErsoCodes::where('erso_code', 'like', "%{$data}%")->get() -> take(30);
    $codes_filtered = [];
    foreach ($codes as $code) {
      array_push($codes_filtered, $code -> id);
    }
    $products = Products::whereIn('erso_code_id', $codes_filtered)
      ->with(['shipowner', 'car', 'brand', 'category', 'erso_code'])
      ->paginate(20);
    $products -> makeHidden(['model_id', 'enterprise_id', 'shipowner_id', 'category_id', 'brand_id']);
    return $products;
  }

}