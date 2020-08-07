<?php

  Route::prefix('api/v1') -> group(function(){
    Route::get('search-car-model/{car}', 'Loftonti\Erso\Controllers\ProductsApiController@serachCarsModels');
    Route::get('search-products/{model}/{shipowner}', 'Loftonti\Erso\Controllers\ProductsApiController@searchCars');
    Route::get('general-search-products/{data}', 'Loftonti\Erso\Controllers\ProductsApiController@GeneralSearchProduct');
    Route::get('code-search-products/{data}', 'Loftonti\Erso\Controllers\ProductsApiController@CodeSearchProduct');
  });