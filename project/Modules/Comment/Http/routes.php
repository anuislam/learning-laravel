<?php

Route::group(['middleware' => 'web', 'prefix' => 'comment', 'namespace' => 'Modules\Comment\Http\Controllers'], function()
{
    Route::post('/post', 'CommentController@add')->name('post_comment');
    Route::patch('/get-all-comments', 'CommentController@get_all_comments')->name('get_all_comments');
    Route::DELETE('/comment-delete/{commentid}', 'CommentController@deleteComment')->name('delete-comment');    
});
