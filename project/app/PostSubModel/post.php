<?php

namespace App\PostSubModel;
use App\post_type;

class post extends post_type{

    public function post_type_setting(){
      return [
        'add_new_title'            => 'Add New Post',
        'all_post_title'            => 'All Posts',
        'edit_post_title'            => 'Edit Post',

        'page_sub_title'        => 'Blog Post',
        'edit_post_type_cap'    => ['edith_post', 'edith_others_post', 'manage_option'],
        'show_post_type_cap'    => ['see_post', 'manage_option'],
        'datatable_post_type_cap'    => ['see_others_post'],
        'delete_post_type_cap'    => ['delete_post', 'delete_others_posts', 'manage_option'],
      ];
    }
}
