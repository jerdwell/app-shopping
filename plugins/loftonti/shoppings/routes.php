<?php


Route::prefix('api/v1/orders') -> group(function(){

  Route::post('create-order', 'LoftonTi\Shoppings\Controllers\ShoppingApiController@createOrder') -> middleware(['Loftonti\Users\Middleware\GuestMiddleware']);

});