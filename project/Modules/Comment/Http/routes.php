<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin-panel', 'namespace' => 'Modules\Comment\Http\Controllers'], function()
{

Route::patch('/action/get-all-comment', 'CommentController@get_all_comment')->name('get_all_comment');

});
