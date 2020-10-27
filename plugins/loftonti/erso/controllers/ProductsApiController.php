<?php namespace Loftonti\Erso\Controllers;

use Illuminate\Routing\Controller;
use Loftonti\Erso\Models\{ Applications, Shipowners, Products, Categories, CarsModels, Brands };
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class ProductsApiController extends Controller {

  public function serachCarsModels($car)
  {
    $car = Str::slug($car);
    return $shipowners = CarsModels::getCarModels($car) -> with(['shipowner', 'car'])  ->get();
  }

  public function serachShipowners($branch, $shipowner)
  {
    $shipowner = Str::slug($shipowner);
    $shipowners = Shipowners::getCarShipowner($branch,$shipowner) -> groupBy('car_id') -> get();
    return $shipowners;
  }

  public function searchCars($branch, $model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null, $filter3 = null, $value3 = null)
  {
    $filters = [];
      if($filter1 != null) $filters[$filter1] = $value1;
      if($filter2 != null) $filters[$filter2] = $value2;
      if($filter3 != null) $filters[$filter3] = $value3;
      if(isset($filters['brand'])){
        $brand = Brands::where('brand_slug', $filters['brand']) -> first();
        $filters['brand'] = !is_null($brand) ? $brand -> id : 1;
      }
    $products = Products::filterCars( $branch, $model, $shipowner, $filters );
    $products_paginated = $products -> paginate(20);
    $brands = $products -> groupBy('brand_id') -> without(['branches', 'applications', 'category']) -> get();
    $years = Applications::filterYear(
      $branch,$model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null
    )->get();
    $categories = Products::filterCategories(
      $model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null, $branch
    )->get();

    return [
      'products' => $products_paginated,
      'years' => $years,
      'categories' => $categories,
      'brands' => $brands
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

  public function GeneralSearchProduct($branch, $data)
  {
    try {
      $applications = Applications::selectRaw('group_concat(product_id) as product_id')
        -> leftJoin('loftonti_erso_shipowners', 'loftonti_erso_shipowners.id','=',"loftonti_erso_application.shipowner_id")
        -> leftJoin('loftonti_erso_cars', 'loftonti_erso_cars.id','=',"loftonti_erso_application.car_id")
        -> where('loftonti_erso_shipowners.shipowner_slug','like',"%$data%")
        -> orWhere('loftonti_erso_cars.car_slug','like',"%$data%")
        -> first();
      $applications = explode(',', $applications -> product_id);
      $products = Products::select('loftonti_erso_products.*')
        ->where('loftonti_erso_products.product_name','like',"%$data%")
        ->orWhere(function ($q) use($applications){
          $q -> whereIn('loftonti_erso_products.id', $applications);
        })
        ->leftJoin('loftonti_erso_product_branch','loftonti_erso_product_branch.product_id','loftonti_erso_products.id')
        ->leftJoin('loftonti_erso_branches','loftonti_erso_branches.id','loftonti_erso_product_branch.branch_id')
        ->where('loftonti_erso_branches.slug',$branch)
        -> with([
          'category',
          'brand',
          'branches',
          'applications.shipowner',
          'applications.car',
        ])
        ->groupBy('loftonti_erso_products.erso_code')
        -> take(500)
        -> paginate(50);
      return $products;
    } catch (\Throwable $th) {
      return response(['Error, datos no localizados', 503]);
    }
  }

  public function CodeSearchProduct($branch, $data)
  {
    $products = Products::select('loftonti_erso_products.*')
      ->leftJoin('loftonti_erso_product_branch','loftonti_erso_product_branch.product_id','loftonti_erso_products.id')
      ->leftJoin('loftonti_erso_branches','loftonti_erso_branches.id','loftonti_erso_product_branch.branch_id')
      ->where('loftonti_erso_branches.slug',$branch)
      ->where('erso_code','like',"%$data%")
      ->with([
        'brand', 
        'category',
        'branches',
        'applications',
        'applications.car',
        'applications.shipowner'
      ])
      ->groupBy('erso_code')
      ->take(30)
      ->paginate(20);
    return $products;
  }

  public function listShipowners()
  {
    $swhipownres = Shipowners::all();
    return $swhipownres;
  }

  public function listShipownersCars($shipowner_id)
  {
    try {
      $list_cars = Applications::select('loftonti_erso_application.id', 'loftonti_erso_application.product_id', 'loftonti_erso_application.shipowner_id', 'car_id')
        ->leftJoin('loftonti_erso_cars','loftonti_erso_cars.id','=','loftonti_erso_application.car_id')
        -> where('loftonti_erso_application.shipowner_id', $shipowner_id)
        -> with([
          'car',
          'shipowner'
        ])
        -> orderBy('loftonti_erso_cars.car_name')
        -> groupBy('car_id')
        -> get();
      return $list_cars;
    } catch (\Throwable $th) {
      return response() -> json([$th -> getMessage(), 403]);
    }
  }

  public function listBrandsRelated($branch, $car, $shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null)
  {
    try {
      $filters = [];
      if($filter1 && $value1) $filters[$filter1] = $value1;
      if($filter2 && $value2) $filters[$filter2] = $value2;
      return $filters;
      $products = Products::selectRaw('distinct brand_id')
        -> whereHas('applications', function(Builder $q) use($shipowner, $car){
        $q -> where('shipowner_id', $shipowner)
        -> where('car_id', $car);
      })
      ->when($filters['year'], function($q) use($filters){
        $q -> whereRaw("{$filters['year']} between substring_index(year, '-', 1) AND substring_index(year, '-', -1)");
      })
      -> with(['brand'])
      ->take(10)
      ->get();
      return $products;
    } catch (\Throwable $th) {
      return response() -> json([$th -> getMessage(), 403]);
    }
  }

}