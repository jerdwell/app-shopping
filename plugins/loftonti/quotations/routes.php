<?php

Route::prefix('/api/v1/quotations') -> group(function(){
    Route::post('/', 'LoftonTi\Quotations\Controllers\Quotations@create')  -> middleware(['Loftonti\Users\Middleware\AuthMiddleware']);
});