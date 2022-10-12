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

//Route::prefix('discount')->group(function() {
//    Route::get('/', 'DiscountController@index');
//});

Route::prefix('discount')->group(function() {
    Route::post('/check', 'Frontend\DiscountController@check')->name('cart.discount.check');
});


