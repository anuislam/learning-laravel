<?php

namespace Modules\Comment\Entities;

use Form;
use Validator;
use Auth;
use DB;
use Session;
use Modules\Comment\Entities\commentModel;
use App\BlogPost;
use App\admin_page;
use Request;
use App\UserPermission;

class editComment extends admin_page{

	private $comment; 
	private $postmodel; 
	private $permission; 

    public function __construct() {

    	$this->comment = new commentModel();
    	$this->postmodel = new BlogPost();
    	$this->permission = new UserPermission();

    }


    public function page_setting(){
    	return [
    		'page_title' 	 => 'Edit Comment',
    		'page_sub_title' => '...',
    		'capability' 	 => 'edit_comment',
    	];
    }


	public function page_content_output($error_msg = ''){
		//Request::input('comment-id')
		
		$commentid = Request::input('comment-id');
		$chack = $this->edith_comment_process($commentid);

		if ($chack) {
			echo Form::open(['url' =>  route('option-update', ['edit-comment', 'comment-id='.$chack->id]), 'method' => 'put']); ?>
			    <div class="row">
			      <div class="col-md-8">
					<?php echo heml_card_open('fa fa-pencil-square-o', 'Edit Comment'); ?>
					  <?php textarea_editor([
					            'name' => 'umessage',
					            'title' => 'Comment',
					            'value' => $chack->message,
					            'atts' =>  [
					              'style' => 'min-height:250px;width:100%;'
					              ]
					          ], $error_msg); ?>  

					<?php echo Form::submit('Update', [
						'class' => 'btn bg-olive btn-flat',
						'style' => 'margin:20px 0 0 0;',
						]); ?>
					<?php echo heml_card_close(); ?>
			      </div>
			    </div>
			<?php echo Form::close(); 
		}else{
			?>
		    <div class="row">
		      <div class="col-md-8">
				<?php echo heml_card_open('fa fa-pencil-square-o', 'Edit Comment'); ?>
					You have no permission to access this comment edith..
				<?php echo heml_card_close(); ?>
		      </div>
		    </div>
		    <?php 
		}

	}

 	public function option_validation($data){
		 return Validator::make($data, [
		                'comment-id'    => 'required|integer|exists:comments,id',
		                'umessage'      => 'required|string|max:5000',
		            ]
		        );
    }

    public function option_update($data){
		$chack = $this->edith_comment_process($data['comment-id']);
		if ($chack) {
			$this->comment->edit_comment_by_id((int)$data['comment-id'], sanitize_text($data['umessage']));
			return redirect()->back()->with('success_msg', 'Comment edit Successful.');
    	}else{
    		return redirect()->back()->with('error_msg', 'You have no permission to access this comment edith..');
    	}
    }


    public function edith_comment_process($comment_id){
    	if (url_gard('integer', $comment_id) === true) {
	    	$comment 	  	 = $this->comment->get_comment_by_id($comment_id);
	    	if ($comment) {
		    	$commenter_email = $comment->email;
		    	$cus_user  		 = Auth::user();
		    	$cur_user_email  = $cus_user->email;
		    	if ($commenter_email != $cur_user_email) {
		    		if ($this->permission->user_can('edit_others_comment', $cus_user->id)) {
		    			return $comment;
		    		}		    		
		    	}else{
		    		if ($this->permission->user_can('edit_comment', $cus_user->id)) {
		    			return $comment;
		    		}
		    	}
	    	}
    	}
    	return false; 
    }

}
