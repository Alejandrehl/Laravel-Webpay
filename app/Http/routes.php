<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index')->name('index');



Route::post('webpay/init', 'WebpayController@init')->name('webpay.init');
Route::get('webpay/token', 'WebpayController@token')->name('webpay.token');

Route::get('webpay/exito', 'WebpayController@exito')->name('webpay.exito');
Route::get('webpay/rechazo', 'WebpayController@rechazo')->name('webpay.rechazo');

Route::post('webpay/voucher', 'WebpayController@voucher')->name('webpay.voucher');
Route::post('webpay/finish', 'WebpayController@finish')->name('webpay.finish');
