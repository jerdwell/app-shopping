<?php

Route::prefix('api/v1/user_system') -> group(function(){

  Route::post('auth', 'LoftonTI\UserSystem\Controllers\UserSystemApi@authUser');

});