<?php

Route::prefix('/v1/products') -> group(function(){
  Route::get('/{type}/{val}/{limit?}', 'AppProducts\Products\Controllers\Products@FindProducts');
});