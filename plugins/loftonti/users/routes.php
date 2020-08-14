<?php
Route::prefix('api/v1') -> group(function(){
  
  Route::post('account/register', 'LoftonTi\Users\Controllers\Users@registerAccount');
  
});
