<?php

namespace Modules\Gymwebsite\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Gymwebsite\Entities\Student;
use App\admin_page;


class joinrequest extends admin_page{

    public function page_setting(){
    	return [
    		'page_title' 	 => 'All Join ',
    		'page_sub_title' => 'Request',
    		'capability' 	 => 'manage_option',
    	];
    }

	public function insert_order($value){
		$req = new Student();
		$req->email 		= sanitize_text($value['email']);
		$req->mobile		= sanitize_text($value['mobile']);
		$req->message 		= sanitize_text($value['message']);
		$req->program_title = sanitize_text($value['program_title']);
		$req->created_at = new \DateTime();
		$req->updated_at = new \DateTime();
		$req->save();
	}
	public function page_content_output($error_msg = ''){
		echo heml_card_open('fa fa-list', 'All Join Request'); ?>

			<table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
			tarms-url="<?php echo route('getjoinrequest'); ?>"
			tarms-data='<?php echo json_encode([
			                ['data' => 'program_title'],
			                ['data' => 'email'],
			                ['data' => 'mobile'],
			                ['data' => 'message'],
			               [
			                 'data'     => 'action',
			                 'searchable' => 'false',
			                 'orderable'  => 'false',
			               ]
			              ]); ?>'
			>
			<thead>
			  <tr>
			    <th>Title</th>
			    <th>Email</th>
			    <th>Mobile</th>
			    <th>Message</th>
			    <th style="width: 125px;">Actions</th>
			  </tr>
			</thead>
			<tfoot>
			  <tr>
			    <th>Title</th>
			    <th>Email</th>
			    <th>Mobile</th>
			    <th>Message</th>
			    <th>Actions</th>
			  </tr>
			  </tr>
			</tfoot>
			</table>

		<?php echo heml_card_close(); ?>

		<?php	
	}
    public function option_validation($data){
    	return ;
    }

    public function option_update($data){
    	return ;
    }

}
