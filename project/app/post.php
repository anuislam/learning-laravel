<?php

namespace App;

use App\User;
use App\UserPermission;
use \Auth;
use Illuminate\Database\Eloquent\Model;
use \DB;
use \Carbon;
use \Validator;
use \Session;
use \Purifier;
use App\Rules\is_own_email;

class post extends Model{

    public function update_post_meta($id, $key, $value){
        $id = (int)$id;
        if ($this->post_meta_exists($id, $key)) {
            $data = DB::table('post_meta')
                    ->where('post_id',  $id)
                    ->where('meta_key',  $key)
                    ->update([
                        'meta_value' => $value
                    ]);            
        }else{
            $data = DB::table('post_meta')->insert([
                'post_id' => $id,
                'meta_key' => $key,
                'meta_value' => $value
            ]);
        }
        return ($data) ? true : false ;

    }

    public function post_meta_exists($id, $key){
        $id = (int)$id;
        $post_meta = DB::table('post_meta')->select('id')->where('post_id', $id)->where('meta_key', $key)->first();
        return (count($post_meta) > 0) ? true : false ;
    }

    public function get_post_meta($id, $key){
        $id = (int)$id;
        $post_meta = DB::table('post_meta')->select('meta_value')->where('post_id', $id)->where('meta_key', $key)->first();

        return (count($post_meta) == 1) ? $post_meta->meta_value : false ;
    }

    public function get_post($id){
        $id = (int)$id;
        $post = DB::table('posts')->where('id', $id)->first();
        return (count($post) == 1) ? $post : false ;
    }

}
