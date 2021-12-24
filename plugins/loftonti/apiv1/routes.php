<?php

use LoftonTi\Apiv1\Services\Auth\Controllers\LoginUserController;

Route::prefix('api/v1') -> group(function()
{

  Route::prefix('applications') -> group(function(){
    Route::get('/', LoftonTi\Apiv1\Services\Applications\Controllers\GetDataApplicationsController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read') -> name('get-applications');
  });

  Route::prefix('auth') -> group(function()
  {
    Route::post('/', LoginUserController::class) -> name('login');
  });

  Route::prefix('branch') -> group(function(){
    Route::post('/products', LoftonTi\Apiv1\Services\Branches\Controllers\GetBranchProductsController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read') -> name('get-branch-products');
  });

  Route::prefix('brands') -> group(function(){
    Route::post('/search', LoftonTi\Apiv1\Services\Brands\Controllers\SearchBrandController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read') -> name('search-brands');
    Route::get('/', LoftonTi\Apiv1\Services\Brands\Controllers\GetBrandsController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read') -> name('get-brands');
  });

  Route::prefix('cars') -> group(function(){
    Route::post('search', LoftonTi\Apiv1\Services\Cars\Controllers\SearchCarsController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read') -> name('search-car');
    Route::post('/', LoftonTi\Apiv1\Services\Cars\Controllers\CreateCarController::class) 
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,create') -> name('create-car');
    Route::get('/', LoftonTi\Apiv1\Services\Cars\Controllers\GetAllCarsController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read') -> name('all-cars');
  });

  Route::prefix('categories') -> group(function(){
    Route::get('/', LoftonTi\Apiv1\Services\Categories\Controllers\GetCategoriesController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read') -> name('all-categories');;
  });

  Route::prefix('customers') -> group(function(){
    Route::post('/', LoftonTi\Apiv1\Services\Customers\Controllers\CreateCustomerController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:customers,create') -> name('create-customer');;
    Route::get('/{id}', LoftonTi\Apiv1\Services\Customers\Controllers\GetCustomerController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:customers,read') -> name('get-customer');;
    Route::post('list', LoftonTi\Apiv1\Services\Customers\Controllers\ListCustomersController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:customers,read') -> name('list-customers');;
  });

  Route::prefix('dashboard') -> group(function()
  {
    Route::get('/products', LoftonTi\Apiv1\Services\Dashboard\Controllers\CountBranchProductsController::class) 
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read') -> name('dashboard-products');
  });

  Route::prefix('enterprises') -> group(function()
  {
    Route::get('/', LoftonTi\Apiv1\Services\Enterprises\Controllers\GetAllEnterprisesController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:enterprises,read') -> name('get-enterprises');
  });

  Route::prefix('products') -> group(function()
  {
    Route::post('sync-file', LoftonTi\Apiv1\Services\Products\Controllers\SyncFileController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,create') -> name('sync-products');
    Route::get('product/{erso_code}', LoftonTi\Apiv1\Services\Products\Controllers\GetProductController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read') -> name('get-product');
    Route::post('/', LoftonTi\Apiv1\Services\Products\Controllers\CreateProductController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read') -> name('create-product');
    Route::post('upload-image', LoftonTi\Apiv1\Services\Products\Controllers\UploadProductImageUseCase::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,update') -> name('upload-product-image');
    Route::delete('/', LoftonTi\Apiv1\Services\Products\Controllers\DeleteProductsController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,delete');
    Route::put('/', LoftonTi\Apiv1\Services\Products\Controllers\UpdateProductController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,update') -> name('update-product');
  });

  Route::prefix('shipowners') -> group(function ()
  {
    Route::post('/search', LoftonTi\Apiv1\Services\Shipowners\Controllers\SearchShipownersController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,read') -> name('search-shipowner');
    Route::post('/', LoftonTi\Apiv1\Services\Shipowners\Controllers\CreateShipownerController::class)
      -> middleware('LoftonTi\Apiv1\Services\Auth\Middleware\UserSystemAuthMiddleware:products,create') -> name('create-shipowner');
  });

});