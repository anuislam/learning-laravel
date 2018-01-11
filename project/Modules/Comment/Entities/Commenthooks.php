<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Model;
use DataTables;
use DB;
use App\UserPermission;
use Auth;
use Carbon;
use App\UserModel;
use App\BlogPost;
use Illuminate\Support\Str;
use Modules\Comment\Entities\Comment;

class Commenthooks extends Model{
    private $permission = '';
    private $usermodel = '';
    private $post = '';
    private $comment = '';

    public function __construct(){
        $this->permission   = new UserPermission();
        $this->usermodel    = new UserModel();
        $this->post         = new BlogPost();
        $this->comment            = new Comment();
        add_action('admin_comment_table_action', [$this, 'admin_comment_table_action_edit']);
        add_action('admin_comment_table_action', [$this, 'admin_comment_table_action_delete']);
        add_action('admin_comment_table_status', [$this, 'admin_comment_table_status_func']);
        add_action('admin_comment_table_in_response', [$this, 'admin_comment_table_in_response_func']);
        add_action('admin_comment_table_created_at', [$this, 'admin_comment_table_created_at_func']);
        add_action('ajax_admin_comment_delete', [$this, 'admin_comment_delete_func']);
        add_filter('pass_admin_dasboard_data', [$this, 'pass_admin_dasboard_data_func']);

    }


    public function admin_comment_table_action_edit($data){
        ?>
            <a href="<?php echo route('admin-page',['comment', 'comment-id' => $data->id]); ?>" class="btn bg-purple btn-flat">Edith</a>
        <?php
    }


    public function admin_comment_table_action_delete($data){
        ?>
            <a  onclick="delete_comment(<?php echo $data->id; ?>)" 
            class="btn bg-maroon btn-flat margin">Delete</a>
        <?php
    }

    public function admin_comment_table_status_func($comment){

        if ($comment->comment_approved == 1) {
            $msg = 'Approved';
        }else if ($comment->comment_approved == 0) {
            $msg = 'Pending';
        }else{
            $msg = 'Trush';
        }
         echo format_status_tag($msg, [
              'success' => 'Approved',
              'warning' => 'Pending',
              'danger'  => 'Trush',
            ]);
    }

    public function admin_comment_table_in_response_func($comment){
        $post = $this->post->get_post((int)$comment->comment_post_id);
        if ($post) {
            echo '<a href="'.route('edit_post_type', [$post->id, $post->post_type]).'">'.Str::words($post->post_title, 3).'</a>';
        }
    }

    public function admin_comment_table_created_at_func($comment){
        echo '<small class="label label-info">'.Carbon\Carbon::parse($comment->created_at)->format('Y/m/d - h:i').'</small>';
    }

    public function admin_comment_delete_func($data){
     $usermodel      = $this->usermodel;
     $current_user   = $usermodel->current_user();
     $data = $data->all();
        $delete_comment_id = $data['comment_id'];
        if (empty($delete_comment_id) === false) {
            if ($this->permission->user_can('delete_comment', $current_user['id'] ) === false) {
                echo 'error';
            }
            $commnt_data =  $this->comment->get_comment($delete_comment_id);
            if ($commnt_data) {
                if ((int)$commnt_data->user_id != (int)$current_user['id']) {
                    if ($this->permission->user_can('delete_others_comment', (int)$current_user['id'] ) === false) {
                        echo 'error';
                    }
                }
                if ($this->comment->delete_comment($delete_comment_id)) {
                    echo 'ok';
                }
            }

        }
    }

   
}
