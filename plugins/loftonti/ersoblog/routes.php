<?php

Route::prefix('api/v1/blog') -> group(function(){
  Route::post('search', 'LoftonTi\ErsoBlog\Controllers\Posts@search');
});