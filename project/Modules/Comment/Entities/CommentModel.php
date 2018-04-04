<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Model;
use Form;
use Validator;
use Auth;
use DB;
use Session;
use App\BlogPost;
use Request;
use App\UserPermission;

class commentModel extends Model{
    
	private $postmodel; 
	private $permission; 

    public function __construct() {

    	$this->postmodel = new BlogPost();
    	$this->permission = new UserPermission();

    }

	public function get_comment_form($route, $errors, $post_id)	{
		$this->remove_session_comment_message($post_id);
		?>
			<?php echo Form::open(['url' =>  $route, 'method' => 'post', 'style' => 'float: left; width: 100%;']);

if(Auth::guest()){
    ?>

			<div class="form-group <?php echo $errors->has('uname') ? 'has-error' : '' ?>">
				<?php echo Form::label( 'uname', 'Name:', ['class' => 'control-label'] ); ?>
				<?php echo Form::text(  'uname', '', [
					'class' => 'form-control',
					'placeholder' => 'Name',
				] ); ?>
				<?php if ($errors->has('uname')) : ?>
			        <span class="help-block">
			            <strong><?php echo $errors->first('uname')  ?></strong>
			        </span>
			     <?php endif; ?>
			</div>

			<div class="form-group <?php echo $errors->has('uemail') ? 'has-error' : '' ?>">
				<?php echo Form::label( 'uemail', 'Email address:', ['class' => 'control-label'] ); ?>
				<?php echo Form::email(  'uemail', '', [
					'class' => 'form-control',
					'placeholder' => 'Email address',
				] ); ?>
				<?php if ($errors->has('uemail')) : ?>
			        <span class="help-block">
			            <strong><?php echo $errors->first('uemail')  ?></strong>
			        </span>
			     <?php endif; ?>
			</div>

			<div class="form-group <?php echo $errors->has('uwebsite') ? 'has-error' : '' ?>">
				<?php echo Form::label( 'uwebsite', 'Website:', ['class' => 'control-label'] ); ?>
				<?php echo Form::url(  'uwebsite', '', [
					'class' => 'form-control',
					'placeholder' => 'Website',
				] ); ?>
				<?php if ($errors->has('uwebsite')) : ?>
			        <span class="help-block">
			            <strong><?php echo $errors->first('uwebsite')  ?></strong>
			        </span>
			     <?php endif; ?>
			</div>


    <?php
}

			 ?>
			<div class="form-group <?php echo $errors->has('umessage') ? 'has-error' : '' ?>">			
				<?php echo Form::label( 'umessage', 'Message:', ['class' => 'control-label'] ); ?>
				<?php echo Form::textarea(  'umessage', '', [
					'class' => 'form-control',
					'placeholder' => 'Message',
				] ); ?>	
				<?php if ($errors->has('umessage')) : ?>
			        <span class="help-block">
			            <strong><?php echo $errors->first('umessage')  ?></strong>
			        </span>
			     <?php endif; ?>	
			</div>
			<div class="form-group">	
				<?php echo Form::submit('Comment', ['class' => 'btn btn-default pull-right']); ?>		
			</div>
			<?php echo Form::hidden('post_id', $post_id); ?>	

		<?php echo Form::close(); ?>

		<?php
	}


	public function comment_validation($data){

		if(Auth::guest())
		{
			return Validator::make($data, [
			                'uname'      	=> 'required|string|max:255',
			                'uemail'      	=> 'required|email|max:255',
			                'uwebsite'      => 'required|url|',
			                'umessage'      => 'required|string|max:5000',
			                'post_id'      	=> 'required|integer|exists:posts,id',
			            ]);
		}

		return Validator::make($data, [
		                'umessage'      => 'required|string|max:5000',
		                'post_id'      	=> 'required|integer|exists:posts,id',
		            ]);
	}


	public function save_comment($data){
      $id = DB::table('comments')->insertGetId([
                'name'          => $data['name'],
                'email'         => $data['email'],
                'website'       => $data['website'],
                'message'       => $data['message'],
                'status'        => $data['status'],
                'user_agent'    => $data['user_agent'],
                'created_at'    => $data['created_at'],
                'updated_at'    => $data['updated_at'],
                'post_id'    	=> $data['post_id'],
            ]);
	}

	public function get_comments($post_id){
		return DB::table('comments')
		->where('post_id', (int)$post_id)
		->where('status', 1)
		->orderby('id', 'DESC')->get();
	}

	public function chack_commment_status($email, $post_id){
		$chack_comment = DB::table('comments')
		->where('post_id', 	(int)$post_id)
		->where('email', 	sanitize_email($email))
		->where('status', 1)->count();
		return ($chack_comment > 0) ? true : false ;
	}

    public function remove_session_comment_message($post_id) {

        $comment_post_email     = session('comment_post_email');
        if ($comment_post_email) {           
            if ($this->chack_commment_status($comment_post_email, $post_id) === true) {
            	Session::forget('comment_post_email');
            	Session::forget('comment_post_message');      	
            }
        }
    }

    public function approve_comment_count($post_id, $singular = 'Comment', $pluraltext = 'Comments', $nocomment = 'No Comment'){
    	$count_comment = DB::table('comments')
		->where('post_id', 	(int)$post_id)
		->where('status', 1)->count();
		if ($count_comment == 0) {
			return $nocomment;
		}else if ($count_comment == 1) {
			return $count_comment.' '.$singular;
		}else{
			return $count_comment.' '.$pluraltext;
		}
    }

    public function get_pending_all_comments($limit = 10){
		return DB::table('comments')
			->where('status', 0)
			->limit((int)$limit)
			->orderby('id', 'DESC')
			->get();
    }

    public function get_comment_by_id($comment_id){
		return DB::table('comments')
			->where('id', '=', (int)$comment_id)
			->first();
    }


	public function chack_commment_status_by_id($comment_id){
		$chack_comment = $this->get_comment_by_id($comment_id);
		if ($chack_comment->status == 1) {
			return true;
		}
		return false;
	}

	public function comment_approve($comment_id){
		return DB::table('comments')
      ->where('id', (int)$comment_id)
      ->update([
        'status'   => 1,
        'updated_at' => new \DateTime(),
      ]);
	}
	public function comment_unapprove($comment_id){
		return DB::table('comments')
      ->where('id', (int)$comment_id)
      ->update([
        'status'   => 0,
        'updated_at' => new \DateTime(),
      ]);
	}


	public function edit_comment_by_id($comment_id, $data){
		return DB::table('comments')
	      ->where('id', (int)$comment_id)
	      ->update([
	        'message'   => $data,
	        'updated_at' => new \DateTime(),
	      ]);
	}

    public function delete_comment_process($comment_id){
    	if (url_gard('integer', $comment_id) === true) {
	    	$comment = $this->get_comment_by_id($comment_id);
	    	if ($comment) {
		    	$commenter_email = $comment->email;
		    	$cus_user  		 = Auth::user();
		    	$cur_user_email  = $cus_user->email;
		    	if ($commenter_email != $cur_user_email) {
		    		if ($this->permission->user_can('delete_others_comment', $cus_user->id)) {
		    			return true;
		    		}		    		
		    	}else{
		    		if ($this->permission->user_can('delete_comment', $cus_user->id)) {
		    			return true;
		    		}
		    	}
	    	}
    	}
    	return false; 
    }


    public function delete_comment($comment_id){
    	DB::table('comments')->where('id', '=', (int) $comment_id)->delete();
    }

}
