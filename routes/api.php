<?php

use Illuminate\Http\Request;


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return auth()->id();
//});

Route::middleware('auth:api')->post('transfer', 'BalanceController@transfer');
