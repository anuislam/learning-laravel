<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserPermission;
use \Auth;
use \Input;
use App\UserModel;
use App\mediaModel;
use Image;
use Validator;
use App\BlogPost;
use App\post_type;

class PostController extends Controller{



    private $usermodel = '';
    private $permission = '';
    private $mediaModel = '';
    private $postmodel = '';
    public function __construct() {
        $this->middleware('auth');
        $this->usermodel    = new UserModel();
        $this->permission   = new UserPermission();  
        $this->mediaModel   = new mediaModel();  
        $this->postmodel    = new BlogPost();  
        $this->post_type    = new post_type(); 
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($data){        
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if (url_gard('mix', $data) === false) {
             return abort(404);
        }

        if (verify_registered_post_type($data) === false) {
            return abort(404);
        }

        $post_opject = 'App\PostSubModel\\'.$data;
        

        if (!class_exists($post_opject)) {
            return abort(404);
        }
        
        $post_opject = new $post_opject();  


        if (chack_post_type_user_roll($post_opject, 'read_post', 'read_post') === false) {
            return abort(404);
        }


        return view('admin.all-posts',[
            'current_user'        => $current_user,
            'userpermission'      => $this->permission,
            'post_type'           => $post_opject,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($urldata){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if (url_gard('mix', $urldata) === false) {
             return abort(404);
        }

        if (verify_registered_post_type($urldata) === false) {
            return abort(404);
        }

        $post_opject = 'App\PostSubModel\\'.$urldata;
        

        if (!class_exists($post_opject)) {
            return abort(404);
        }

        $post_opject = new $post_opject();

        if (chack_post_type_user_roll($post_opject, 'create_posts', 'create_posts') === false) {
            return abort(404);
        }


        return view('admin.post-new',[
            'current_user'        => $current_user,
            'userpermission'      => $this->permission,
            'post_type'           => $post_opject,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_type = ''){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if (url_gard('mix', $post_type) === false) {
             return redirect()->back()->with('error_msg', 'Invalid post type.' );
        }


        if (verify_registered_post_type($post_type) === false) {
            return redirect()->back()->with('error_msg', 'Invalid post type.' );
        }

        $post_opject = 'App\PostSubModel\\'.$post_type;
        

        if (!class_exists($post_opject)) {
            return redirect()->back()->with('error_msg', 'Invalid post type.' );
        }

        $post_opject = new $post_opject();

        if (chack_post_type_user_roll($post_opject, 'create_posts', 'create_posts') === false) {
            return redirect()->back()->with('error_msg', 'You have no permission.' );
        }

        return $post_opject->post_type_data_process($request, $post_type);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($post_type) {

        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();
        $table_query     = array();

        if (url_gard('mix', $post_type) === false) {
              return false;
        }

        if (verify_registered_post_type($post_type) === false) {
             return false;
        }

        $post_opject = 'App\PostSubModel\\'.$post_type;

        if (!class_exists($post_opject)) {
            return false;
        }

        $post_opject = new $post_opject();


        if (chack_post_type_user_roll($post_opject, 'read_post', 'read_post') === false) {
            return false;
        }

        if (chack_post_type_user_roll($post_opject, 'read_others_post', 'read_others_post') === false) {
            $table_query['author'] = $current_user['id'];
        }

        $table_query['post_type'] = $post_type;
        
        return $post_opject->get_post_for_datatable($table_query);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $post_type){



        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();



            if (url_gard('integer', $id) === false) {
                 return abort(404);
            }

            if (url_gard('mix', $post_type) === false) {
                 return abort(404);
            }

            if (verify_registered_post_type($post_type) === false) {
                return abort(404);
            }

            $post_opject = 'App\PostSubModel\\'.$post_type;
            if (!class_exists($post_opject)) {
                return abort(404);
            }
            $post_opject = new $post_opject();

            $edit_post_data = $this->postmodel->get_post($id, ['post_type' => $post_type]);
            if ($edit_post_data === false){
                return abort(404);
            }


            if (chack_post_type_user_roll($post_opject, 'edith_post', 'edith_post') === false) {
                return abort(404);
            }

            if ($current_user['id'] != $edit_post_data->post_author) {
                if (chack_post_type_user_roll($post_opject, 'edith_others_post', 'edith_others_post') === false) {
                    return abort(404);
                }
            }
            return view('admin.post-edit',[
                'current_user'        => $current_user,
                'userpermission'      => $this->permission,
                'post_type'           => $post_opject,
                'data_value'           => $edit_post_data,
            ]);
        


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $post_type){


        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();


        if (url_gard('integer', $id) === false) {
             return redirect()->back()->with('error_msg', 'Invalid post type id.' );
        }

        if (url_gard('string', $post_type) === false) {
             return redirect()->back()->with('error_msg', 'Invalid post type.' );
        }

        if (verify_registered_post_type($post_type) === false) {
            return redirect()->back()->with('error_msg', 'Invalid post type.' );
        }

        $post_opject = 'App\PostSubModel\\'.$post_type;
        if (!class_exists($post_opject)) {
            return redirect()->back()->with('error_msg', 'Invalid post type.' );
        }

        $post_opject = new $post_opject();

        $edit_post_data = $this->postmodel->get_post($id, ['post_type' => $post_type]);
        if ($edit_post_data === false){
            return redirect()->back()->with('error_msg', 'Invalid post type.' );
        }


        if (chack_post_type_user_roll($post_opject, 'edith_post', 'edith_post') === false) {
            return redirect()->back()->with('error_msg', 'You have no permission.' );
        }

        if ($current_user['id'] != $edit_post_data->post_author) {
            if (chack_post_type_user_roll($post_opject, 'edith_others_post', 'edith_others_post') === false) {
                return redirect()->back()->with('error_msg', 'You have no permission.' );
            }
        }

        return $post_opject->post_type_edit_data_process($request, $post_type, (int)$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, $post_type){

        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if (url_gard('integer', $id) === false) {
             return redirect()->back()->with('error_msg', 'Invalid post type id.' );
        }

        if (url_gard('string', $post_type) === false) {
             return redirect()->back()->with('error_msg', 'Invalid post type.' );
        }

        if (verify_registered_post_type($post_type) === false) {
            return redirect()->back()->with('error_msg', 'Invalid post type.' );
        }

        $post_opject = 'App\PostSubModel\\'.$post_type;
        if (!class_exists($post_opject)) {
            return redirect()->back()->with('error_msg', 'Invalid post type.' );
        }

        $post_opject = new $post_opject();

        $edit_post_data = $this->postmodel->get_post($id, ['post_type' => $post_type]);
        if ($edit_post_data === false){
            return redirect()->back()->with('error_msg', 'Invalid post type.' );
        }


        if (chack_post_type_user_roll($post_opject, 'delete_post', 'delete_post') === false) {
            return redirect()->back()->with('error_msg', 'You have no permission.' );
        }

        if ($current_user['id'] != $edit_post_data->post_author) {
            if (chack_post_type_user_roll($post_opject, 'delete_others_post', 'delete_others_post') === false) {
                return redirect()->back()->with('error_msg', 'You have no permission.' );
            }
        }
        
        return $this->post_type->prepare_delete_post($id, $post_type);
    }


    public function chack_slug(Request $request){
        $post_data = $request->all();
        $value = $post_data['value'];
        $post_id = (int)$post_data['post_id'];
        if (empty($value) === false) {
            $slug = sunatize_slug_text($value);
            if ($this->postmodel->chack_post_post_slug($slug, $post_id) === false) {
                return [
                    'type'=> 'error',
                    'message'=> 'Slug Exists'
                ];
            }else{
                return [
                    'type'=> 'success',
                    'value' => $slug,
                ];
            }
        }
        return false;
    }
}
