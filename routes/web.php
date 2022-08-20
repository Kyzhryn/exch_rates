<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/exchangerates', [Controllers\ExchangeRates::class, 'showPageWithExchangeRates']);


Route::get('/settings', [Controllers\ExchangeRates::class, 'showPageWithSettings']);

Route::post('/save_settings_gettings', [Controllers\ExchangeRates::class, 'saveSettingsGetting']);

Route::post('/save_settings_view', [Controllers\ExchangeRates::class, 'saveSettingsView']);

Route::get('/getNewRecords', [Controllers\ExchangeRates::class, 'getExchangeRates'] );

Route::get('/1', [Controllers\ExchangeRates::class, 'setExchangeRates']);

Route::get('/short_ref', [Controllers\ShortRef::class,'mainPage']);
