<?php

namespace App\PostSubModel;
use App\post_type;

class post extends post_type{

    public function post_type_setting(){
          return [
            'add_new_title'            => 'Add New Post',
            'all_post_title'            => 'All Posts',
            'edit_post_title'            => 'Edit Post',
            'page_sub_title'        => 'Blog Page',
            'capability'            => [
                  'edith_post'          => 'edith_post', 
                  'edith_others_post'  => 'edith_others_post',  
                  'read_post'          => 'read_post', 
                  'read_others_post'   => 'read_others_post', 
                  'delete_post'        => 'delete_post', 
                  'delete_others_post' => 'delete_others_post', 
                  'create_posts'       => 'create_posts', 
            ],

          ];
    }
}
