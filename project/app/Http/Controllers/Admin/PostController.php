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
use App\post;
use App\post_type;

class PostController extends Controller{



    private $usermodel = '';
    private $permission = '';
    private $mediaModel = '';
    private $postmodel = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->usermodel    = new UserModel();
        $this->permission   = new UserPermission();  
        $this->mediaModel   = new mediaModel();  
        $this->postmodel    = new post();  
        $this->post_type    = new post_type();  
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if ($this->permission->user_can('edith_post', $current_user['id']) === false) {
            return '404 page';
        }
        return view('admin.post-new',[
                'current_user'        => $current_user,
                'userpermission'      => $this->permission,
                'post_type'           => $this->post_type,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
