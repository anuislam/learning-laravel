<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Comment\Entities\commentModel;
use Auth;
use Purifier;
use DataTables;
use DB;
use Form;
use App\BlogPost;

class CommentController extends Controller
{
    private $commentModel;
    public function __construct()
    {
        $this->commentModel    = new commentModel(); 
        $this->BlogPost        = new BlogPost(); 
    }

    public function index()
    {
        //return view('comment::index');
    }

    public function add(request $request){
        $this->commentModel->comment_validation($request->all())->validate();
        $data = $request->all();
        if(Auth::guest()){
            $session_email = sanitize_email($data['uemail']);
            if ($this->commentModel->chack_commment_status($data['uemail'], $data['post_id']) === true) {
                $comment_status = 1;
            }else{
                $comment_status = 0;
            }
            $this->commentModel->save_comment([
                'name'          => sanitize_text($data['uname']),
                'email'         => sanitize_email($data['uemail']),
                'website'       => sanitize_text(@$data['website']),
                'message'       => Purifier::clean($data['umessage'], array(
                                            'HTML.Allowed'             => 'b,strong,span,a,em,a[href|title],ul,ol,li,p[style],br,img[width|height|alt|src],h1,h2,h3,h4,h5,h6',
                                            'AutoFormat.AutoParagraph' => true,
                                            'HTML.Nofollow' => true,
                                    )),
                'status'        => $comment_status,
                'user_agent'    => $request->header('User-Agent'),
                'created_at'    => new \DateTime(),
                'updated_at'    => new \DateTime(),
                'post_id'       => (int)$data['post_id'],
            ]);
        }else{
            $user = Auth::user();
            $session_email = $user->email;
            if ($this->commentModel->chack_commment_status($user->email, $data['post_id']) === true) {
                $comment_status = 1;
            }else{
                $comment_status = 0;
            }
            $this->commentModel->save_comment([
                'name'          => $user->fname.' '. $user->lname,
                'email'         => $user->email,
                'website'       => NULL,
                'message'       => Purifier::clean($data['umessage'], array(
                                            'HTML.Allowed'             => 'b,strong,span,a,em,a[href|title],ul,ol,li,p[style],br,img[width|height|alt|src],h1,h2,h3,h4,h5,h6',
                                            'AutoFormat.AutoParagraph' => true,
                                            'HTML.Nofollow' => true,
                                    )),
                'status'        => $comment_status,
                'user_agent'    => $request->header('User-Agent'),
                'created_at'    => new \DateTime(),
                'updated_at'    => new \DateTime(),
                'post_id'       => (int)$data['post_id'],
            ]);            
        }
        if ($comment_status == 0) {
            session(['comment_post_message' => 'Your comment has been queued for review by site administrators and will be published after approval.']);
            session(['comment_post_email' => $session_email]);

        }

        return redirect()->back();
    }


    public function get_all_comments(){
        $this->middleware('auth');
        return DataTables::of(DB::table('comments')->select('id','name', 'email', 'message', 'status', 'created_at', 'post_id'))
        ->addColumn('comment_pic', function ($comment) {
          return get_gravatar_custom_img( $comment->email, 50, 'mm', 'g', true);
        })
        ->addColumn('created_at', function ($comment) {
          return '<small><i class="fa fa-clock-o"></i> '.\Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->diffForHumans().'</small>';
        })
        ->addColumn('status', function ($comment) {
            return format_status_tag($comment->status, [
                                  'danger'  => '0',
                                  'success' => '1',
                                ]);
        })
        ->addColumn('message', function ($comment) {
            return read_more(10, $comment->message);
        })
        ->addColumn('action', function ($comment) {
            ob_start();
            ?>   
                <form method="POST" action="<?php echo route('option-update', 'comments'); ?>" accept-charset="UTF-8" style="display:inline-block;">
                    <input name="_method" type="hidden" value="PUT">
                    <?php 
                        if (is_approve($comment->status) === true) {                           
                            echo Form::submit('Unapprove', ['class' => 'btn bg-olive margin']);
                        }else{
                            echo Form::submit('Approve', ['class' => 'btn bg-orange margin']);
                        }
                     ?>
                    <?php echo Form::hidden('comment_id', $comment->id ); ?>                     
                    <?php echo Form::hidden('_token', csrf_token() ); ?>                     
                </form>

            <a href="<?php echo route('admin-page', ['edit-comment', 'comment-id='.$comment->id]); ?>" class="btn bg-purple margin">Edith</a>

            <a href="<?php echo $this->BlogPost->get_permalink($comment->post_id, 'single_post'); ?>" class="btn bg-navy margin" target="_blank">View</a>
            <a
                onclick="data_modal(this)" 
                data-title="Ready to Delete?"
                data-message='Are you sure you want to delete?'
                cancel_text="Cancel"
                submit_text="Delete"
                data-type="post"
                data-parameters='{"_token":"<?php echo csrf_token(); ?>", "_method": "DELETE"}'
                href="<?php echo route('delete-comment', $comment->id); ?>" 
                class="btn bg-maroon btn-flat margin">Delete</a>
            <?php
            return ob_get_clean();
        })
        ->escapeColumns(['*'])
        ->make(true);;
    }


    public function deleteComment($comment_id){
        $this->middleware('auth');
        $chack = $this->commentModel->delete_comment_process($comment_id);
        if ($chack) {
            $this->commentModel->delete_comment($comment_id);
            return redirect()->back()->with('success_msg', 'Comment Delete Successful.');
        }else{
            return redirect()->back()->with('error_msg', 'You have no permission to access this comment..');
        }
    }


}
