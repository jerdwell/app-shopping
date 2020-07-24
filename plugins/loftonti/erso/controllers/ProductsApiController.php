<?php namespace Loftonti\Erso\Controllers;

use Illuminate\Routing\Controller;
use Loftonti\Erso\Models\{ Shipowners, Products, Categories };
use Illuminate\Support\Str;

class ProductsApiController extends Controller {

  public function serachCars($car)
  {
    $car = Str::slug($car);
    $shipowners = Shipowners::select('id', 'shipowner_name', 'shipowner_slug')
      -> where('shipowner_name', 'like', "%{$car}%")
      -> get();
    return $shipowners;
  }

  public function getModels($car)
  {
    $shipowner = Shipowners::where('shipowner_slug', $car) -> first();
    $models = Products::select('model_id')
      ->where('shipowner_id', $shipowner->id)
      ->distinct()
      ->with('car')
      ->get();
    return $models;
  }

  public function SearchProductCategoryModel($model, $category)
  {
    $category = Categories::where('category_slug', $category)->first();
    if(empty($category)) return response(['Categoría no encontrada'], 404);
    $products = Products::where('model_id', $model)
      -> where('category_id', $category->id)->get();
    return $products;
  }

}