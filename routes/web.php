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

Route::get('/', function () {
    return view('welcome');
});

Route::post('add-user', 'UserController@addUser');
Route::post('update-user', 'UserController@updateUser');

Route::post('deposit', 'UserController@depositCash');
Route::post('withdraw', 'UserController@withdrawCash');

Route::post('report', 'UserController@reportTransactions');