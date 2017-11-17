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

class MediaController extends Controller
{
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
    }

    public function index()    {
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();
        if ($this->permission->user_can('see_media', $current_user['id']) === false) {   
            return '404 page';
        }


        return view('admin.media',[
                'current_user'        => $current_user,
                'userpermission'      => $this->permission,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if ($this->permission->user_can('upload_file', $current_user['id']) === false) {
            return '404 page';
        }
        return view('admin.add-new-media',[
                'current_user'        => $current_user,
                'userpermission'      => $this->permission,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if ($this->permission->user_can('upload_file', $current_user['id']) === false) {
            return  response()->json([
                'type'      => 'error',
                'errors'    => ['file' => ['Error: You have no file upload permission.']],
            ]);
        }

        $validation = Validator::make($request->all(), [
            'file' => 'required|max:102400000|mimes:psd,txt,doc,pdf,docx,zip,rar,csv,jpg,png,jpeg,gif,ico,JPG,PNG,GIF,mp4,mp3,mkv'
        ], [
            'required'  => 'Error: Empty file.',
            'max'       => 'Error: File size too large.',
            'mimes'     => 'Error: Invalid file type.',
        ]);

        if ($validation->passes()) {
            $invalid_file = [
                'js',
                'css',
                'html',
                'php',
            ];

            if ($request->hasFile('file')) {          
                $file       = $request->file('file');
                $extension  = $file->getClientOriginalExtension();
                foreach ($invalid_file as $value) {
                    if ($value == $extension) {
                       return  response()->json([
                            'type'      => 'error',
                            'errors'    => ['file' => ['Error: Invalid file type.']],
                        ]);
                    }
                }
            }

            $return_data = $this->mediaModel->process_store_media($request);
            return  response()->json($return_data);
        }else{
            $error_val = $validation->errors('file');
            return  response()->json([
                'type'      => 'error',
                'errors'    => $error_val,
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return '404 page';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();
        if (url_gard('integer', $id) === false) {
             return '404 page';
        }

        if ($this->permission->user_can('edith_media', $current_user['id']) === false) {
            return '404 page';
        }

        $media = $this->mediaModel->get_media($id);
        if ($media === false) {
           return '404 page';
        }

        if ($current_user['id'] != $media->post_author) {
            if ($this->permission->user_can('edith_others_media', $current_user['id']) === false) {
                return '404 page';
            }
        }

        return view('admin.edithmedia',[
            'current_user'        => $current_user,
            'userpermission'      => $this->permission,
            'media'               => $media,
            'meta'                => $this->postmodel,
            'mediamodel'          => $this->mediaModel,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();
        if (url_gard('integer', $id) === false) {
             return redirect()->back()->with('error_msg', 'Invalid url data.' );
        }

        if ($this->permission->user_can('edith_media', $current_user['id']) === false) {
            return redirect()->back()->with('error_msg', 'You can not edith media.' );
        }

        $media = $this->mediaModel->get_media($id);
        if ($media === false) {
           return redirect()->back()->with('error_msg', 'Media not exists.' );
        }

        if ($current_user['id'] != $media->post_author) {
            if ($this->permission->user_can('edith_others_media', $current_user['id']) === false) {
                return redirect()->back()->with('error_msg', 'You can not edith others media.' );
            }
        }

        $this->mediaModel->process_edith_media($request, $id);

        return redirect()->back()->with('success_msg', 'Media Update successful.' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();
        if (url_gard('integer', $id) === false) {
             return redirect()->back()->with('error_msg', 'Invalid url data.' );
        }

        if ($this->permission->user_can('delete_media', $current_user['id']) === false) {
            return redirect()->back()->with('error_msg', 'You can not delete media.' );
        }

        $media = $this->mediaModel->get_media($id);
        if ($media === false) {
           return redirect()->back()->with('error_msg', 'Media not exists.' );
        }

        if ($current_user['id'] != $media->post_author) {
            if ($this->permission->user_can('delete_others_media', $current_user['id']) === false) {
                return redirect()->back()->with('error_msg', 'You can not delete others media.' );
            }
        }

        $this->mediaModel->process_delete_media($id);

        return redirect()->back()->with('success_msg', 'Media delete successful.' );
    }

    

    public function media_datatable(){
        $cur_user = Auth::user();
        if ($this->permission->user_can('see_media', $cur_user->id) === false) {   
            return false;
        }
        return $this->mediaModel->get_media_datatable();
        
    }

}
