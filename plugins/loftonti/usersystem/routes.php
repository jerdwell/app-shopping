<?php

Route::prefix('api/v1/user_system') -> group(function(){

  Route::post('auth', 'LoftonTI\UserSystem\Controllers\UserSystemApi@authUser');

  Route::prefix('resources') -> group(function(){
    Route::get('all-enterprises', 'LoftonTi\Usersystem\Controllers\UserSystemResourcesApi@getAllEnterprises');
  });

});