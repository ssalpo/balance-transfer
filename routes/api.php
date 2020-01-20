<?php

Route::post('/auth', 'UserController@auth');

Route::middleware('auth:api')->group(function () {

    Route::get('/balance', 'BalanceController@show');

    Route::post('/transfer', 'BalanceController@transfer');
    Route::post('/transfer', 'BalanceController@transfer');

    Route::get('/transactions', 'TransactionController@index');
    Route::get('/transactions/{id}', 'TransactionController@show');

});


// Добавлено для тестовых целей
if (env('APP_DEBUG', 'false')) {
    Route::group(['prefix' => 'test'], function () {
        Route::post('/delete/user', function () {
            $userId = \request('id');

            if ($userId) {
                App\User::find()->delete();
            }
        });

        Route::get('/transactions', function () {
            return App\Transaction::all();
        });
    });
}
