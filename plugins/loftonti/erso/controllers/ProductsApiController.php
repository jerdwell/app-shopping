<?php namespace Loftonti\Erso\Controllers;

use Illuminate\Routing\Controller;
use Loftonti\Erso\Models\{ Applications, Shipowners, Products, Categories, CarsModels, ErsoCodes, Brands };
use Illuminate\Support\Str;

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

  public function searchCars($branch, $model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null)
  {
    $products = Products::filterCars(
      $branch, $model, $shipowner, $filter1, $value1, $filter2, $value2
    )->paginate(20);
    $years = Applications::filterYear(
      $branch,$model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null
      )->get();

    $categories = Products::filterCategories(
      $model,$shipowner, $filter1 = null, $value1 = null, $filter2 = null, $value2 = null, $branch
    )
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
      $list_cars = Applications::select('id', 'product_id', 'shipowner_id', 'car_id')
        -> where('shipowner_id', $shipowner_id)
        -> with([
          'car',
          'shipowner'
        ])
        -> groupBy('car_id')
        -> get();
      return $list_cars;
    } catch (\Throwable $th) {
      return response() -> json([$th -> getMessage(), 403]);
    }
  }

}