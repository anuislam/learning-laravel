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
    Route::post('/users/datatable', 'Admin\UserDatatable@index')->name('user-datatable');
    Route::get('/change-password', 'Admin\UsersController@change_password')->name('change-password');
    Route::post('/update-change-password', 'Admin\UsersController@update_change_password')->name('update-change-password');
    Route::get('/tarm/{tarm?}', 'Admin\tarmController@index')->name('create-tarms');
    Route::post('/tarm/{tarm?}', 'Admin\tarmController@stor')->name('stor-tarms');
    Route::PATCH('/tarm/all/{tarm?}', 'Admin\tarmController@get_all')->name('tarms-all');
    Route::get('/edit-tarm/{tarm?}/{edit?}', 'Admin\tarmController@edith_tarms')->name('edit-tarm');
    Route::PATCH('/edit-tarm/{tarm?}/{edit?}', 'Admin\tarmController@edit_tarm_update')->name('edit-tarm-update');
    Route::DELETE('/delete-tarm/{tarm?}/', 'Admin\tarmController@delete_tarm')->name('delete-tarm');

});

Route::get('/home', 'HomeController@index')->name('home');
