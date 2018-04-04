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

class allComments extends admin_page{

	private $comment; 
	private $postmodel; 

    public function __construct() {

    	$this->comment = new commentModel();
    	$this->postmodel = new BlogPost();

    }


    public function page_setting(){
    	return [
    		'page_title' 	 => 'All Comments',
    		'page_sub_title' => '...',
    		'capability' 	 => 'manage_comment',
    	];
    }


	public function page_content_output($error_msg = ''){
		?>

		<?php echo Form::open(['url' =>  route('option-update', 'gym-header-setting'), 'method' => 'PUT']); ?>
		    <div class="row">
		      <div class="col-md-12">

				<?php echo heml_card_open('fa fa-user', 'All page'); ?>

				<table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
				tarms-url="<?php echo route('get_all_comments'); ?>"
				tarms-data='<?php echo json_encode([
				['data' => 'comment_pic'],
				['data' => 'name'],
				['data' => 'email'],
				['data' => 'message'],
				[
				'data'     => 'created_at',
				'searchable' => 'false',
				'orderable'  => 'false',
				],
				[
				'data' => 'status',
				'searchable' => 'true',
				'orderable'  => 'false',
				],
				[
				'data'     => 'action',
				'searchable' => 'false',
				'orderable'  => 'false',
				]
				]); ?>'
				>
					<thead>
						<tr>
							<th>Image</th>
							<th>Name</th>
							<th>Email</th>
							<th>Message</th>
							<th>Date</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Image</th>
							<th>Name</th>
							<th>Email</th>
							<th>Message</th>
							<th>Date</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
						</tr>
					</tfoot>
				</table>

				<?php echo heml_card_close(); ?>
		      </div>
		    </div>
		<?php echo Form::close(); ?>

		<?php
	}

 	public function option_validation($data){
		return Validator::make($data, [
                'comment_id'        => 'required|integer|exists:comments,id',
            ]
        );
    }

    public function option_update($data){
        $comment = $this->comment->get_comment_by_id($data['comment_id']);
        if (count($comment) == 1) {
        	if ($this->comment->chack_commment_status_by_id($data['comment_id'])) {
        		$this->comment->comment_unapprove($data['comment_id']);
        		return redirect()->back()->with('success_msg', 'Comment Update Successful.');
        	}else{
        		$this->comment->comment_approve($data['comment_id']);
        		return redirect()->back()->with('success_msg', 'Comment Update Successful.');
        	}
        }
        return redirect()->back()->with('error_msg', 'Opps: Something is Wrong!!' );
    }


}
