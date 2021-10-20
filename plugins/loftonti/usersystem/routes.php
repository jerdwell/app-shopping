<?php

// use LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware as AuthMiddleware;

Route::prefix('api/v1/user_system') -> group(function(){

  /**
   * Auth Routes
   */
  Route::post('auth', 'LoftonTI\UserSystem\Controllers\UserSystemApi@authUser');

  /**
   * Routes for single resources
   */
  Route::prefix('resources') -> group(function(){
    Route::get('all-enterprises', 'LoftonTi\Usersystem\Controllers\UserSystemResourcesApi@getAllEnterprises');
  });


  /**
   * Routes product handler
   */
  Route::prefix('products') -> group(function ()
  {
    Route::get('dashboard-data', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@dashboardData') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    Route::post('upload-sync-file', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@uploadFileSync') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,create']);
  });

});