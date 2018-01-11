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

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin-panel'], function () {

    Auth::routes();
    Route::get('/', 'Admin\DashboardController@index');
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    
    Route::resource('/user', 'Admin\UsersController');
    Route::get('/users', 'Admin\UsersController@all_users')->name('all-users');
    Route::post('/user/stor-user', 'Admin\UsersController@stor_user')->name('stor-user');
    Route::patch('/users/datatable', 'Admin\UserDatatable@index')->name('user-datatable');
    Route::get('/change-password', 'Admin\UsersController@change_password')->name('change-password');
    Route::post('/update-change-password', 'Admin\UsersController@update_change_password')->name('update-change-password');
    Route::get('/tarm/{tarm?}', 'Admin\tarmController@index')->name('create-tarms');
    Route::post('/tarm/{tarm?}', 'Admin\tarmController@stor')->name('stor-tarms');
    Route::patch('/tarm/all/{tarm?}', 'Admin\tarmController@get_all')->name('tarms-all');
    Route::get('/edit-tarm/{tarm?}/{edit?}', 'Admin\tarmController@edith_tarms')->name('edit-tarm');
    Route::patch('/edit-tarm/{tarm?}/{edit?}', 'Admin\tarmController@edit_tarm_update')->name('edit-tarm-update');
    Route::DELETE('/delete-tarm/{tarm?}/', 'Admin\tarmController@delete_tarm')->name('delete-tarm');
    Route::resource('/media', 'Admin\MediaController');
    Route::patch('/media-all', 'Admin\MediaController@media_datatable')->name('media_datatable');

    Route::post('/uploder', 'Admin\uploderController@index')->name('get-uploder');
    Route::patch('/uploder/search', 'Admin\uploderController@search')->name('search-uploder');
    Route::DELETE('/uploder/{tarm?}', 'Admin\uploderController@delete')->name('delete-uploder');
    Route::put('/uploder/{tarm?}', 'Admin\uploderController@update')->name('update-uploder');

    Route::get('/post-type/all/{post_type}', 'Admin\PostController@index')->name('all-posts');
    Route::patch('/post-type/all/{post_type}', 'Admin\PostController@show')->name('get-all-posts');
    Route::get('/post-type/{post}', 'Admin\PostController@create')->name('create_post_type');
    Route::get('/post-type/{post}/edit/{post_type}', 'Admin\PostController@edit')->name('edit_post_type');
    Route::post('/post-type/{post}', 'Admin\PostController@store')->name('stor_post');
    Route::patch('/post-type/{post}/{post_type}', 'Admin\PostController@update')->name('post_type_update');
    Route::DELETE('/post-type/{post}/{post_type}', 'Admin\PostController@destroy')->name('post_type_delete');
    Route::post('/chack-slug', 'Admin\PostController@chack_slug')->name('chack-slug');

    Route::get('/page/{post}', 'Admin\adminpageController@index')->name('admin-page');
    Route::put('/page/{post}', 'Admin\adminpageController@update')->name('option-update');

    Route::put('/add-menu-item', 'Admin\menuController@add_item')->name('add_menu_item');
    Route::patch('/add-menu-item', 'Admin\menuController@delete_item')->name('delete_menu_item');
    Route::put('/add-main-menu', 'Admin\menuController@add_main_menu')->name('add_main_menu');
    Route::DELETE('/delete-menu', 'Admin\menuController@delete_main_menu')->name('delete_menu');

    Route::get('/action/facebook', 'Admin\facebookController@facebook_action')->name('facebook_action');
    Route::get('/action/facebook/callback', 'Admin\facebookController@facebook_calback')->name('facebook_calback');

    Route::get('/action/twitter', 'Admin\twitterController@twitter_action')->name('twitter_action');
    Route::get('/action/twitter/callback', 'Admin\twitterController@twitter_calback')->name('twitter_calback');
    
    Route::get('/action/google', 'Admin\googleController@google_action')->name('google_action');
    Route::get('/action/google/callback', 'Admin\googleController@google_calback')->name('google_calback');



    Route::get('/action/confirm-registration', 'Admin\socialLoginController@show_confirm_registration')->name('show_confirm_registration');
    Route::post('/action/confirm-registration', 'Admin\socialLoginController@confirm_registration')->name('confirm_registration');

    Route::get('/setting/log', 'Admin\LogViewerController@index')->name('log_edit');
    
    Route::post('/action/ajax', 'Admin\ajaxController@handle_ajax_request')->name('ajax_url');

});

