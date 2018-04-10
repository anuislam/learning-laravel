<?php

Route::group(['middleware' => 'web', 'prefix' => '/', 'namespace' => 'Modules\Gymwebsite\Http\Controllers'], function()
{
    Route::GET('/home', 'GymwebsiteController@index');
    Route::GET('/', 'GymwebsiteController@index');
    Route::patch('/admin-panel/gymwebsite/getjoinrequest', 'GymwebsiteController@getjoinrequest')->name('getjoinrequest');
    Route::DELETE('/admin-panel/gymwebsite/getjoinrequest/{delete}', 'GymwebsiteController@deletejoinrequest')->name('deletejoinrequest');
    Route::GET('/post/{post}', 'SinglePostController@index')->name('single_post');
    Route::GET('/event/{event}', 'SingleEventController@index')->name('event');
    Route::GET('/page/{page}', 'SinglePageController@index')->name('page');
    Route::POST('/contact/send-mail', 'contactController@send_mail')->name('send_mail');
});
	