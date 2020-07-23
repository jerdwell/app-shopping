<?php

  Route::prefix('api/v1') -> group(function(){
    
    Route::get('search-car/{car}', 'Loftonti\Erso\Controllers\ProductsApiController@serachCars');
    Route::get('get-models/{car}', 'Loftonti\Erso\Controllers\ProductsApiController@getModels');

  });