<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

Route::post('/auth', 'UserController@auth');

Route::middleware('auth:api')->group(function () {

    Route::get('/balance', 'BalanceController@show');
    Route::post('/transfer', 'BalanceController@transfer');

    Route::get('/transactions', 'TransactionController@index');
    Route::get('/transactions/{id}', 'TransactionController@show');

});


// Добавлено для тестовых целей
if (env('APP_DEBUG', 'false')) {
    Route::group(['prefix' => 'test'], function () {

        // удаление пользователя
        Route::post('/delete/{id}/user', function ($userId) {
            if ($userId) {
                App\User::find()->delete();
            }
        });

        // Добавляет нового пользователя
        Route::post('/store/user', function () {

            $data = request(['name', 'email', 'password']);

            if (count($data) == 3) {
                $data['password'] = Hash::make($data['password']);
                $data['api_token'] = hash('sha256', Str::random(60));

                $user = App\User::create($data);

                return $user->makeVisible('api_token');
            }
        });

        // Возвращает список всех транзакций
        Route::get('/transactions', function () {
            return App\Transaction::all();
        });
    });
}
