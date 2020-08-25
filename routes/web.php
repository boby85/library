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
    return redirect ('login');
})->middleware('guest');

Route::resource('books', 'BookController')->middleware('role:1,2');
Route::resource('users', 'UserController')->middleware('role:1,2');
Route::resource('owes', 'OweController')->middleware('role:1,2');

Route::get('changePassword', 'UserController@changePassword')->name('changePassword')->middleware('auth');
Route::patch('updatePassword', 'UserController@updatePassword')->name('updatePassword')->middleware('auth');

Auth::routes(['register' => false]);

Route::resource('home', 'HomeController')->middleware('role:3');;
Route::resource('admin', 'AdminController')->middleware('role:1');
