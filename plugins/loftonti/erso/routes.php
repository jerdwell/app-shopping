<?php

  Route::prefix('api/v1') -> group(function(){
    
    Route::get('search-car/{car}', 'Loftonti\Erso\Controllers\ProductsApiController@serachCars');
    Route::get('get-models/{car}', 'Loftonti\Erso\Controllers\ProductsApiController@getModels');
    Route::get('search-product-category-model/{model}/{category}', 'Loftonti\Erso\Controllers\ProductsApiController@SearchProductCategoryModel');
    Route::get('general-search-products/{data}', 'Loftonti\Erso\Controllers\ProductsApiController@GeneralSearchProduct');

  });