<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use BotMan\Drivers\Telegram\TelegramDriver;

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');

Route::get('/success', function () {
    if (!str_contains(request()->fullUrl(), 'redirected')) {
        return view('redirect');
    }
<<<<<<< HEAD
    $code = request()->get('access_token');
    $expiresIn = request()->get('expires_in');
    $userId = request()->get('user_id');
    var_dump($code, $expiresIn, $userId);
    resolve('botman')->say('Authorized user ' . $userId, 121010156, TelegramDriver::class);
});
=======

    $code = request()->get('access_token');
    $expiresIn = request()->get('expires_in');
    $userId = request()->get('user_id');

    var_dump($code, $expiresIn, $userId);

    resolve('botman')->say('Authorized user ' . $userId, 77434259, TelegramDriver::class);
});
>>>>>>> 8b01fdf... Царский подгон
