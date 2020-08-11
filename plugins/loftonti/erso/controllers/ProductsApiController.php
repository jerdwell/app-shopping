<?php namespace Loftonti\Erso\Controllers;

use Illuminate\Routing\Controller;
use Loftonti\Erso\Models\{ Shipowners, Products, Categories, CarsModels, ErsoCodes };
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class ProductsApiController extends Controller {

  public function serachCarsModels($car)
  {
    $car = Str::slug($car);
    $shipowners = Shipowners::getCarModels($car) -> groupBy('model_id') -> get();
    return $shipowners;
  }

  public function searchCars($model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null)
  {
    $products = Products::filterCars(
      $model, $shipowner, $filter1, $value1, $filter2, $value2
    )->paginate(20);
    
    $years = Products::filterYear(
      $model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null
      )->get();

    $categories = Products::filterCategories(
      $model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null
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
      $shipowners = Shipowners::where('shipowner_slug', 'like', "%{$data}%") -> get();
      $models = CarsModels::where('model_slug', 'like', "%{$data}%") -> get();
      $shipowner_filtered = [];
      $models_filtered = [];
      foreach ($shipowners as $shipowner) {
        array_push($shipowner_filtered, $shipowner -> id);
      }
      foreach ($models as $model) {
        array_push($models_filtered, $model -> id);
      }
      $products = Products::whereIn('shipowner_id',$shipowner_filtered)
        ->orWhereIn('model_id',$models_filtered)
        ->with([ 'car', 'shipowner', 'brand' ])
        ->get()
        ->take(50);
      return $products;
    } catch (\Throwable $th) {
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
      ->with(['shipowner', 'car', 'brand', 'category'])
      ->get()
      ->take(20);
    $products -> makeHidden(['model_id', 'enterprise_id', 'shipowner_id', 'category_id', 'brand_id', 'provider_price', 'provider_code']);
    return $products;
  }

}