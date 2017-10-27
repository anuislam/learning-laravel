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

Route::group(['prefix' => 'admin'], function () {

    Auth::routes();
    Route::get('logout', 'Auth\LoginController@blank_logout');
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::resource('/user', 'Admin\UsersController');
    Route::get('/users', 'Admin\UsersController@all_users')->name('all-users');
    Route::post('/user/stor-user', 'Admin\UsersController@stor_user')->name('stor-user');
    Route::get('/users/datatable', 'Admin\UserDatatable@index')->name('user-datatable');

});

Route::get('/home', 'HomeController@index')->name('home');
