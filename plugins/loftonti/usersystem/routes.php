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
    /**
     * products
     */
    Route::post('/all', 'LoftonTI\Usersystem\Controllers\UserSystemProductResources@getAllProductsForBranch') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    Route::post('product', 'LoftonTI\Usersystem\Controllers\UserSystemProductResources@createProductController') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,create']);
    Route::put('product', 'LoftonTI\Usersystem\Controllers\UserSystemProductResources@updateProductController') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,create']);
    Route::get('product/{erso_code}', 'LoftonTI\Usersystem\Controllers\UserSystemProductResources@getProductController') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    Route::post('image', 'LoftonTI\Usersystem\Controllers\UserSystemProductResources@uploadProduct') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    /**
     * brands
     */
    Route::post('search-brands', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@searchBrands') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    Route::get('brands', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@getBrands') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    /**
     * categories
     */
    Route::get('/categories', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@getCategories') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    /**
     * cars
     */
    Route::get('cars', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@getCars') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    Route::post('search-cars', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@searchCars') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    Route::post('create-car', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@createCar') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,create']);
    /**
     * shipwoners
     */
    Route::post('search-shipowner', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@searchShipowners') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    Route::post('create-shipowner', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@createShipowner') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    /**
     * mixed
     */
    Route::get('data-applications', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@getCarsAndShipowners') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    
     /**
     * dashboard
     */
    Route::get('dashboard-data', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@dashboardData') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,read']);
    Route::post('upload-sync-file', 'LoftonTi\Usersystem\Controllers\UserSystemProductsHandler@uploadFileSync') -> middleware(['LoftonTi\Usersystem\Middleware\UserSystemAuthMiddleware:products,create']);
  });

});