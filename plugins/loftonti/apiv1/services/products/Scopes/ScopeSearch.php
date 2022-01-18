<?php

namespace LoftonTi\Apiv1\Services\Products\Scopes;

trait ScopeSearch
{

  public function search(?int $car, ?int $shipowner, ?int $category, ?int $brand, ?int $year, ?string $erso_code)
  {
    return $this -> select('loftonti_erso_products.*')
      -> when($car || $shipowner, function($car_query) use($car, $shipowner, $year){
        $car_query -> leftJoin('loftonti_erso_application', 'loftonti_erso_application.product_id', 'loftonti_erso_products.id')
          -> when($car, function($query) use($car){
            $query -> where('car_id', $car);
          })
          -> when($shipowner, function($query) use($shipowner){
            $query -> where('shipowner_id', $shipowner);
          })
          -> when($year, function($query) use($year){
            $query -> whereRaw("$year between substring_index(year, '-', 1) AND substring_index(year, '-', -1)");
          });
      })
      -> when($brand, function($brand_query) use($brand){
        $brand_query -> where('brand_id', $brand);
      })
      -> when($category, function($category_query) use ($category){
        $category_query -> where('category_id', $category);
      })
      -> when($erso_code, function($erso_code_query) use($erso_code){
        $erso_code_query -> where('erso_code', 'like', "%$erso_code%");
      })
      -> with([
        'applications',
        'applications.car',
        'applications.shipowner',
        'brand',
        'category',
        'branches'
      ])
      -> orderBy('product_name')
      -> paginate(100);
  }

}