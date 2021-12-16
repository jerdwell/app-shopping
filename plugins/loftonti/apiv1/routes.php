<?php

use LoftonTi\Apiv1\Services\Auth\Controllers\LoginUserController;

Route::prefix('api/v1') -> group(function(){

  Route::prefix('auth') -> group(function(){
    Route::post('/', LoginUserController::class) -> name('login');
  });

});