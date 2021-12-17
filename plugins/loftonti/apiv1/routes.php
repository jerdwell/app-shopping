<?php

use LoftonTi\Apiv1\Services\Auth\Controllers\LoginUserController;

Route::prefix('api/v1') -> group(function()
{

  Route::prefix('auth') -> group(function()
  {
    Route::post('/', LoginUserController::class) -> name('login');
  });

  Route::prefix('dashboard') -> group(function()
  {
    Route::get('/products', LoftonTi\Apiv1\Services\Dashboard\Controllers\CountBranchProductsController::class) 
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read');
  });

  Route::prefix('enterprises') -> group(function()
  {
    Route::get('/', LoftonTi\Apiv1\Services\Enterprises\Controllers\GetAllEnterprisesController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:enterprises,read');
  });

  Route::prefix('products') -> group(function()
  {
    Route::post('sync-file', LoftonTi\Apiv1\Services\Products\Controllers\SyncFileController::class)
    -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,create');
  });

  Route::prefix('cars') -> group(function(){
    Route::post('search', LoftonTi\Apiv1\Services\Cars\Controllers\SearchCarsController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,create');;
  });

});