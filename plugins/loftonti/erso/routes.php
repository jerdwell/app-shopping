<?php

  Route::prefix('api/v1') -> group(function(){
    Route::get('search-car-model/{car}', 'Loftonti\Erso\Controllers\ProductsApiController@serachCarsModels');
    Route::get('search-products/{branch}/{model}/{shipowner}/{filter1?}/{value1?}/{filter2?}/{value2?}', 'Loftonti\Erso\Controllers\ProductsApiController@searchCars');
    Route::get('general-search-products/{branch}/{data}', 'Loftonti\Erso\Controllers\ProductsApiController@GeneralSearchProduct');
    Route::get('code-search-products/{branch}/{data}', 'Loftonti\Erso\Controllers\ProductsApiController@CodeSearchProduct');
    Route::post('contact-form', 'Loftonti\Erso\Controllers\ContactForm@contactForm');
  });