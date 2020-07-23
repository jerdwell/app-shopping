<?php namespace Loftonti\Erso\Controllers;

use Illuminate\Routing\Controller;
use Loftonti\Erso\Models\{ Shipowners, Products };
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
    $shipowners = Shipowners::where('shipowner_slug', $car)
      ->with(['Products' => function($query){
        $query -> select('id','product_model', 'product_name', 'erso_code', 'product_year') -> get();
      }]) -> get();
    return $shipowners;
  }

}