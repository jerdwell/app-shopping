<?php
Route::prefix('api/v1') -> group(function(){
  
  Route::post('account/register', 'LoftonTi\Users\Controllers\Users@registerAccount');
  Route::post('account/login', 'LoftonTi\Users\Controllers\Users@userLogin');
  Route::post('account/recovery-account', 'LoftonTi\Users\Controllers\Users@recoveryAccount');
  Route::get('account/data-account', 'LoftonTi\Users\Controllers\Users@dataAccount') -> middleware(['Loftonti\Users\Middleware\AuthMiddleware']);
  Route::post('account/update/{action}', 'LoftonTi\Users\Controllers\Users@updateAccount') -> middleware(['Loftonti\Users\Middleware\AuthMiddleware']);
  Route::post('account/password', 'LoftonTi\Users\Controllers\Users@passwordUpdate') -> middleware(['Loftonti\Users\Middleware\AuthMiddleware']);
  
});
