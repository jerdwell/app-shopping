<?php

Route::prefix('/api/v1/quotations') -> group(function(){
    Route::post('/', 'LoftonTi\Quotations\Controllers\Quotations@create')  -> middleware(['Loftonti\Users\Middleware\AuthMiddleware']);
    Route::get('/list', 'LoftonTi\Quotations\Controllers\Quotations@list')  -> middleware(['Loftonti\Users\Middleware\AuthMiddleware']);
    Route::get('/get/{id}/{token}', 'LoftonTi\Quotations\Controllers\Quotations@get');
    Route::post('/download/guest', 'LoftonTi\Quotations\Controllers\Quotations@downloable') -> middleware(['Loftonti\Users\Middleware\GuestMiddleware']);
    Route::get('/download/temp/{data}', 'LoftonTi\Quotations\Controllers\Quotations@tempQuotation') -> middleware(['Loftonti\Users\Middleware\GuestMiddleware']);
    Route::delete('/cancel', 'LoftonTi\Quotations\Controllers\Quotations@cancelQuotation') -> middleware(['Loftonti\Users\Middleware\AuthMiddleware']);
});

Route::get('/backend/loftonti/quotations/quotations/quotation/{id}','LoftonTi\Quotations\Controllers\Quotations@retriveiwQuotation');