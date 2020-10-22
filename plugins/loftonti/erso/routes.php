<?php

  Route::prefix('api/v1') -> group(function(){
    Route::get('list-shipowners', 'Loftonti\Erso\Controllers\ProductsApiController@listShipowners');
    Route::get('list-shipowners-cars/{shipowner_id}', 'Loftonti\Erso\Controllers\ProductsApiController@listShipownersCars');
    Route::get('search-car-model/{car}', 'Loftonti\Erso\Controllers\ProductsApiController@serachCarsModels');
    Route::get('search-shipowner/{branch}/{shipowner}', 'Loftonti\Erso\Controllers\ProductsApiController@serachShipowners');
    Route::get('search-products/{branch}/{model}/{shipowner}/{filter1?}/{value1?}/{filter2?}/{value2?}', 'Loftonti\Erso\Controllers\ProductsApiController@searchCars');
    Route::get('general-search-products/{branch}/{data}', 'Loftonti\Erso\Controllers\ProductsApiController@GeneralSearchProduct');
    Route::get('code-search-products/{branch}/{data}', 'Loftonti\Erso\Controllers\ProductsApiController@CodeSearchProduct');
    Route::post('contact-form', 'Loftonti\Erso\Controllers\ContactForm@contactForm');
    // Route::get('relate-products-stock', 'Loftonti\Erso\Controllers\ContactForm@relateTest');
  });

  Route::post('/backend/loftonti/products/upload-file-update-stock','LoftonTi\Erso\Controllers\Products@uploadFileUpdateStock');