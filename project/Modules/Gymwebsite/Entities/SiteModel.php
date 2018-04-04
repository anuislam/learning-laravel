<?php

namespace Modules\Gymwebsite\Entities;

use Illuminate\Database\Eloquent\Model;
use App\post_type;
use Form;
use App\TarmModel;
use App\UserPermission;
use Auth;
use Input;
use App\UserModel;
use App\mediaModel;
use Image;
use Validator;
use App\BlogPost;
use DB;
use Purifier;
use DataTables;
use Carbon;

class SiteModel extends post_type{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_class_bu_class_cat_id($class_cat_id){
      $data = DB::table('posts')
        ->join('post_meta', 'posts.id', '=', 'post_meta.post_id')
        ->select('posts.*', 'post_meta.*')
        ->where('post_meta.meta_key', 'class_cat')
        ->where('post_meta.meta_value', 'like', '%'.$class_cat_id.'%')
        ->limit(4)
        ->get();

        return $data;
    }

    public function get_all_programs($limit = 0){
        
        $data = DB::table('posts');
        $data->select('id', 'post_title', 'post_content');
        $data->where('post_type', 'program'); 
        if (($limit > 0)) {
            $data->limit($limit);
        }
        return $data->get();
    }

    public function get_all_trainers($limit = 0){
        
        $data = DB::table('posts');
        $data->select('id', 'post_title', 'post_content');
        $data->where('post_type', 'trainer'); 
        if (($limit > 0)) {
            $data->limit($limit);
        }
        return $data->get();
    }


}
