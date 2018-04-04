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

class SinglePageController extends Controller
{
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
    public function index($data) {

        if (url_gard('mix', $data) === false) {
             return abort(404);
        }

        $postdata = $this->BlogPost->post_type_query()->where('post_type', '=', 'page')->where('post_slug', '=', sanitize_text($data))->first();
        if (count($postdata) == 1) {
             $post = $postdata;
             $page_template = $this->BlogPost->get_post_meta($post->id, 'page_template');
        }else{
            return abort(404);
        }

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
        
        if ($page_template) {
	        return view($page_template, [            
            'media'         => $this->mediaModel,
            'meta_data'     => $this->BlogPost,
            'class_cat'     => $class_cat,
            'class_data'    => $class_data,
            'programs'      => $this->SiteModel->get_all_programs(),
            'trainers'      => $this->SiteModel->get_all_trainers(),
            'post'          => $post,
            'comment'       => new comment(),
            'usermodel'     => $this->usermodel,
            
            ])->compileShortcodes();
        }

        return view('gymwebsite::page', [            
            'media'         => $this->mediaModel,
            'meta_data'     => $this->BlogPost,
            'class_cat'     => $class_cat,
            'class_data'    => $class_data,
            'programs'      => $this->SiteModel->get_all_programs(),
            'trainers'      => $this->SiteModel->get_all_trainers(),
            'post'          => $post,
            'comment'       => new comment(),
            'usermodel'     => $this->usermodel,
            
        ])->compileShortcodes();
    }
    
}
