<?php

use LoftonTi\Apiv1\Services\Auth\Controllers\LoginUserController;

Route::prefix('api/v1') -> group(function(){

  Route::prefix('auth') -> group(function(){
    Route::post('/', LoginUserController::class) -> name('login');
  });

  Route::prefix('dashboard') -> group(function(){
    Route::get('/products', LoftonTi\Apiv1\Services\Dashboard\Controllers\CountBranchProductsController::class) 
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read');
    // Route::get('/products', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@dashboardData') 
    //   -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read');
  });

});