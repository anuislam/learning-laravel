<?php

namespace Modules\Gymwebsite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\post_type;
use App\BlogPost;
use App\mediaModel;
use DataTables;
use Modules\Gymwebsite\Entities\SiteModel;
use Modules\Gymwebsite\Entities\Student;
use Modules\Blog\Entities\PostQuery as Post;
use Modules\Comment\Entities\commentModel as comment;

class SinglePostController extends Controller
{
    private $post_type = '';
    private $SiteModel = '';
    private $mediaModel = '';

    public function __construct()    {
        $this->post_type    = new post_type();  
        $this->SiteModel    = new SiteModel();  
        $this->BlogPost    = new BlogPost();  
        $this->mediaModel    = new mediaModel();  
    }

    public function index($data) {

        if (url_gard('mix', $data) === false) {
             return abort(404);
        }

        $postdata = Post::approved_post()->where('post_slug', '=', sanitize_text($data))->first();
        if (count($postdata) == 1) {
             $post = $postdata;
        }else{
            return abort(404);
        }


        return view('gymwebsite::single', [
            'media'         => $this->mediaModel,
            'meta_data'     => $this->BlogPost,
            'post'          => $post,
            'comment'       => new comment(),
        ]);
    }
    
}
