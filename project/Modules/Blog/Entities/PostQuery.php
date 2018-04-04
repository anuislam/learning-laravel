<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class PostQuery {

    static function post_all(){
    	return DB::table('posts')->where('post_type', 'post');
    }

    static function approved_post(){
    	return DB::table('posts')->where('post_type', 'post')->where('status', '1');
    }

    static function post_trush(){
    	return DB::table('posts')
    	->where('post_type', 'post')
    	->where('status', '!=', '0')
    	->where('status', '!=', '1')
    	->where('status', '!=', '3');
    }

    static function post_pending(){
    	return DB::table('posts')->where('post_type', 'post')->where('status', '0');
    }

    static function postpone(){
    	return DB::table('posts')->where('post_type', 'post')->where('status', '3');
    }

}
