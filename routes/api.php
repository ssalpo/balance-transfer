<?php

use Illuminate\Http\Request;


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return auth()->id();
//});


Route::middleware('auth:api')->group(function () {

    Route::post('/transfer', 'BalanceController@transfer');

    Route::get('/transactions', 'TransactionController@index');
    Route::get('/transactions/{id}', 'TransactionController@show');

});
