<?php

use Illuminate\Http\Request;

Route::post('/auth', 'UserController@auth');

Route::middleware('auth:api')->group(function () {

    Route::get('/balance', 'BalanceController@show');

    Route::post('/transfer', 'BalanceController@transfer');
    Route::post('/transfer', 'BalanceController@transfer');

    Route::get('/transactions', 'TransactionController@index');
    Route::get('/transactions/{id}', 'TransactionController@show');

});

Route::get('/test/delete/user', function () {
    $userId = \request('id');

    if ($userId) {
        App\User::find()->delete();
    }

});
