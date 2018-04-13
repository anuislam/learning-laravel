<?php

/*
|--------------------------------------------------------------------------
| Register Namespaces And Routes
|--------------------------------------------------------------------------
|
| When a module starting, this file will executed automatically. This helps
| to register some namespaces like translator or view. Also this file
| will load the routes file for each module. You may also modify
| this file as you want.
|
*/

if (!app()->routesAreCached()) {
    require __DIR__ . '/Http/routes.php';
}

$user_rool = new App\UserPermission();
$user_rool->role([
   'role' => 'administrator',
   'title' => 'Administrator',
])->role([
   'role' => 'author',
   'title' => 'Author',
])->role([
   'role' => 'subscriber',
   'title' => 'Subscriber',
])
->cap('administrator', [
    'edith_user'        => true,
    'edith_other_user'  => true,
    'edith_post'        => true,
    'edith_others_post'  => true,
    'create_posts'  => true,
    'read_post'          => true,
    'read_others_post'  => true,
    'delete_post'  => true,   
    'delete_others_post' => true,
    'manage_option'     => true,
    'create_user'        => true,
    'edith_roll'         => true,
    'delete_user'        => true,
    'change_password'    => true,
    'create_tarm'        => true,
    'upload_file'        => true,
    'edith_media'        => true,
    'edith_others_media'         => true,
    'delete_media'  => true,   
    'delete_others_media' => true,
    'see_media'          => true,        
    'see_others_media'   => true,
    'edith_page'         => true,
    'edith_other_page'   => true,
    'read'     => true,
])
->cap('author', [
    'edith_user'        => true,
    'edith_other_user'  => true,
    'change_password'  => true,
    'create_tarm'  => true,
    'upload_file'  => true,
    'edith_media'  => true,
    'delete_media'  => true,   
    'see_media'          => true, 
    'read'  => true,
])
->cap('subscriber', [
    'change_password'        => true,
    'read'        => true,
]);

