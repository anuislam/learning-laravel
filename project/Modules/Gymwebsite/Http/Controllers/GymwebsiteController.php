<?php

namespace Modules\Gymwebsite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\post_type;
use App\BlogPost;
use App\mediaModel;
use DataTables;
use App\UserModel;
use Modules\Gymwebsite\Entities\SiteModel;
use Modules\Gymwebsite\Entities\Student;
use Modules\Blog\Entities\PostQuery as Post;
use Modules\Comment\Entities\commentModel as comment;

class GymwebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    private $post_type = '';
    private $SiteModel = '';
    private $mediaModel = '';
    private $usermodel = '';

    public function __construct()    {
        $this->post_type    = new post_type();  
        $this->SiteModel    = new SiteModel();  
        $this->BlogPost    = new BlogPost();  
        $this->mediaModel    = new mediaModel();  
        $this->usermodel    = new UserModel();  
    }

    public function index(){

        $class_cat = $this->post_type->get_post_type_tarm([
                          'tarm-type' => 'class-cat'
                        ]);
        $class_data = [];

        foreach ($class_cat as $cat_key => $cat_value) {
            $class_data[$cat_key] = [
                'class_cat' => $cat_value,
                'post_data' => $this->SiteModel->get_all_class_bu_class_cat_id((int)$cat_key),
            ];
        }


        return view('gymwebsite::index',[            
            'media'         => $this->mediaModel,
            'meta_data'     => $this->BlogPost,
            'class_cat'     => $class_cat,
            'class_data'    => $class_data,
            'programs'      => $this->SiteModel->get_all_programs(6),
            'trainers'      => $this->SiteModel->get_all_trainers(6),
            'posts'         => Post::approved_post()->limit(2)->orderBy('id', 'DESC')->get(),
            'comment'       => new comment(),
            'usermodel'     => $this->usermodel,
            'events'        => $this->BlogPost->post_type_query()->where('post_type', '=', 'event')->limit(2)->orderby('id', 'DESC')->get(),
            
        ])->compileShortcodes();
    }


    public function getjoinrequest(){
        return DataTables::of(Student::query())
        ->addColumn('action', function ($post) {
                return '<a href="javascript:void(0)" onclick="joinrequestviewmodal(this)" class="btn bg-purple btn-flat">View</a> <a onclick="data_modal(this)" 
            data-title="Ready to Delete?"
            data-message=\'Are you sure you want to delete?\'
            cancel_text="Cancel"
            submit_text="Delete"
            data-type="post"
            data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'
                href="'.route('deletejoinrequest', [$post->id]).'" class="btn bg-maroon btn-flat margin">Delete</a>';
            })
        ->escapeColumns(['*'])
        ->make(true);
    }

    public function deletejoinrequest(Request $request, $id){
        $Student = Student::where('id', (int)$id);
        $count = $Student->count();
        if ($count == 1) {
           $Student->delete();
           return redirect()->back()->with('success_msg', 'Request Delete successful.');
        }
        return redirect()->back()->with('error_msg', 'Invalid Request.' );
    }

}
