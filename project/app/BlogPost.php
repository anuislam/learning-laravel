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
use \DataTables;
use App\Rules\is_own_email;
use App\TarmModel;
use App\Post;

class BlogPost extends Model{


    private $permission = '';
    private $post = '';
    public function __construct(){
        $this->permission = new UserPermission(); 
        $this->usermodel  = new UserModel();  
        $this->tarmmodel  = new TarmModel();  
    }

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

    public function get_post($id, $post_query = false){
        $id = (int)$id;
        $post = DB::table('posts');
        $post->where('id', $id);
        if (isset($post_query['post_type']) !== false) {
           $post->where('post_type','=' , $post_query['post_type']);
        }
        $post_data = $post->first();

        return (count($post_data) == 1) ? $post_data : false ;
    }

    public function chack_post_post_slug($slug, $id = false){
        $post = DB::table('posts');
        $post->where('post_slug', $slug);
        $data = $post->first();
        if ($post->count() > 0) {
            if ($id == $data->id) {
                return ($post->count() == 1) ? true : false ;
            }
            return false;
        }
        return true;
    }

  public function slug_format($slug, $post_id = false){
    
    $rep = ['@','!','#','$','%','^','<','>','.','?',')','(','=','/','\\','"','\'','&','*',';',':','[',']','|','_','+'
            ];
    $slug = str_replace(' ', '-', $slug);
    $slug = str_replace($rep, '', $slug);

    if ($this->chack_post_post_slug($slug, $post_id) === false) {
      $next_id  = DB::select("show table status like 'posts'");
      $next_id  = $next_id[0]->Auto_increment;    
      $slug .= '-'.$next_id;  
    }
    return strtolower($slug);
  }



  public function get_permalink($post_id, $route){
    $data = $this->get_post($post_id);
    if ($data->post_type == 'post') {        
        return route($route, $data->post_slug);
    }else{
        return route($data->post_type, $data->post_slug);
    }
  }

  public function post_type_query() {
      return DB::table('posts');
  }

}
