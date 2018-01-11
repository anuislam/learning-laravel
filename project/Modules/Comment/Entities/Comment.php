<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Model;

use App\TarmModel;
use App\mediaModel;
use App\admin_page;
use App\Post;
use Form;
use Auth;
use Validator;
use DB;
use Purifier;
use App\options;
use Shortcode;
use Request;
use App\UserModel;
use App\UserPermission;
use DataTables;
use App\BlogPost;

class Comment extends admin_page{
    private $usermodel = '';
    private $permission = '';
    private $mediaModel = '';
    private $postmodel = '';
    private $tarmmodel = '';

    public function __construct() {
        $this->usermodel    = new UserModel();
        $this->post    = new BlogPost();
        $this->permission   = new UserPermission();  
    }

    public function page_setting(){
    	return [
    		'page_title' => 'Comment',
    		'page_sub_title' => 'All Comment',
            'capability' => 'comment_edit',
    	];
    }

    public function page_content_output($error_msg = ''){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();
        $comment_id = Request::input('comment-id');

        if (is_null($comment_id) === false) {
            $comment_id = (int)$comment_id;
            $comment_data = $this->get_comment($comment_id);
            if ($comment_data) {
                echo Form::open(['url' => route('admin-page',['comment', 'comment-id' => $comment_id]), 'method' => 'put']);
                ?>
                    <div class="row">
                        <div class="col-sm-12">                    
                            <?php echo heml_card_open('fa fa-comments', 'All comments'); ?>
                            <?php echo textarea_field([
                                        'name' => 'comment_content',
                                        'title' => 'Comment',
                                        'value' => $comment_data->comment_content,
                                        'atts' =>  [
                                            'placeholder' => 'Comment content', 
                                            'aria-describedby' => 'Comment content', 
                                            'class' => 'form-control',
                                            'rows' => 3,
                                        ]
                                      ], $error_msg); ?>
                            <?php echo  Form::submit('Update Comment', ['class' => 'btn bg-olive btn-flat']); ?>
                            <?php echo heml_card_close(); ?>
                        </div>
                    </div>
                <?php
                echo Form::close();
            }
        }
        ?>
        <?php echo heml_card_open('fa fa-comments', 'All comments'); ?>
              <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
                tarms-url="<?php echo route('get_all_comment'); ?>"
                tarms-data='<?php echo json_encode([
                                   ['data' => 'profile'],
                                   ['data' => 'comment_author'],
                                   ['data' => 'comment_content'],
                                   ['data' => 'comment_post_id'],
                                   ['data' => 'created_at'],
                                   ['data' => 'status'],
                                   ['data' => 'action'],
                              ]); ?>'
              >
                <thead>
                  <tr>
                    <th width="35">Profile</th>
                    <th>Author</th>
                    <th>Comment</th>
                    <th>In Response To</th>
                    <th>Submitted On</th>
                    <th>Comment status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th width="35">Profile</th>
                    <th>Author</th>
                    <th>Comment</th>
                    <th>In Response To</th>
                    <th>Submitted On</th>
                    <th>Comment status</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
              </table>
        <?php echo heml_card_close(); ?>
        <?php

    }


    public function option_validation($data){
    	return Validator::make($data, [
                'comment_content'      => 'required|string',
            ],[
          'comment_content.required' => 'The Comment field is required.',
          'comment_content.string'   => 'The Comment must be given string.',
            ]
        );
    }

    public function option_update($data){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if ($this->permission->user_can('comment_edit', $current_user['id'] ) === false) {
            return redirect()->back()->with('error_msg', 'Failed to update comment.');
        }
        
        $commnt_data =  $this->get_comment($data['comment-id']);

        if ($commnt_data) {
            if ((int)$commnt_data->user_id != (int)$current_user['id']) {
                if ($this->permission->user_can('edit_others_comment', (int)$current_user['id'] ) === false) {
                    return redirect()->back()->with('error_msg', 'Failed to update comment.');
                }
            }
            $this->update_comment($data['comment-id'],  $data['comment_content']);
            return redirect()->back()->with('success_msg', 'Comment Update successful.');
        }
        return redirect()->back()->with('error_msg', 'Failed to update comment.');
    }

    public function get_all_comment_table(){

        $current_user = $this->usermodel->current_user();
        if ($this->permission->user_can( 'comment_edit' , $current_user['id'] ) === false) {
          return false;
        } 

        $comment_query = DB::table('comment');

        if ($this->permission->user_can( 'edit_others_comment' , $current_user['id'] ) === false) {
          $comment_query->where('user_id', $current_user['id']);
        }

        $comment_query->select('id','comment_author', 'comment_content', 'comment_post_id', 'created_at', 'user_id', 'comment_email', 'comment_approved');

        $datatable = DataTables::of($comment_query);

        $datatable->addColumn('profile', function ($comment) {
           $avatar = $this->usermodel->get_user_meta($comment->user_id, 'avatar');
           if ($avatar === false) {
               $avatar = $this->usermodel->get_gravatar_img($comment->comment_email, 35);
           }
          ob_start();

            ?>
    
            <img src="<?php echo $avatar; ?>" alt="Profile" style="width: 35px;height: 35px;">

            <?php
          return ob_get_clean();
            });

        $datatable->addColumn('comment_post_id', function ($comment) {
          ob_start();
			do_action( 'admin_comment_table_in_response', $comment );
          return ob_get_clean();
        });

        $datatable->addColumn('action', function ($comment) {
          ob_start();
            do_action( 'admin_comment_table_action', $comment );
          return ob_get_clean();
            });


        $datatable->addColumn('status', function ($comment) {
          ob_start();
            do_action( 'admin_comment_table_status', $comment );
          return ob_get_clean();
            });


        $datatable->addColumn('created_at', function ($comment) {
          ob_start();
            do_action( 'admin_comment_table_created_at', $comment );
          return ob_get_clean();
            });

        $datatable->escapeColumns(['*']);
        $exe_table = $datatable->make(true);
        return $exe_table;

    }

    public function comment_count($post_id){
        $comment_query = DB::table('comment');
        $comment_query->where('comment_post_id', $post_id);
        return $comment_query->count();
    }

    public function get_comment($comment_id){
        $comment_id = (int)$comment_id;
        $comment_id = DB::table('comment')->where('id', $comment_id)->first();
        return (count($comment_id) == 1) ? $comment_id : false ;
    }

    public function update_comment($comment_id, $value){
        $comment_id = (int)$comment_id;
        $data = DB::table('comment')
            ->where('id',  $comment_id)
            ->update([
                'comment_content' => sanitize_text($value)
        ]);
        return ($data) ? true : false ;
    }

    public function delete_comment($comment_id){
        $data = DB::table('comment')->where('id', $comment_id)->delete();
        if ($data) {
          DB::table('comment_meta')->where('comment_id', $comment_id)->delete();
          return true;
        }
         return false;
    }
}
 