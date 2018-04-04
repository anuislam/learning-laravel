<?php

namespace Modules\Gymwebsite\Entities;

use Illuminate\Database\Eloquent\Model;
use App\post_type;
use Form;
use App\TarmModel;
use App\UserPermission;
use Auth;
use Input;
use App\UserModel;
use App\mediaModel;
use Image;
use Validator;
use App\BlogPost;
use DB;
use Purifier;
use DataTables;
use Carbon;

class program extends post_type{
    private $usermodel = '';
    private $permission = '';
    private $mediaModel = '';
    private $postmodel = '';
    private $tarmmodel = '';

    public function __construct()
    {
        $this->usermodel    = new UserModel();
        $this->permission   = new UserPermission();  
        $this->mediaModel   = new mediaModel();  
        $this->postmodel    = new BlogPost();  
        $this->tarmmodel    = new TarmModel();  
        parent::__construct();
    }

    public function post_type_setting(){
      return [
        'add_new_title'            => 'Add New program',
        'all_post_title'            => 'All program',
        'edit_post_title'            => 'Edit program',
        'page_sub_title'        => 'program'
      ];
    }

  public function post_content_output($error_msg = ''){
    $this->post_type_output(route('stor_post', ['program']), $error_msg);
  } 

public function post_type_output( $route, $error_msg , $value = '' ){

	if (empty($value) === false) {
	  $method = 'PATCH';
	}else{
	  $method = 'POST';
	}
		echo Form::open(['url' =>  $route, 'method' => $method])
		?>
    <div class="row">
      <div class="col-md-8">
		<?php echo heml_card_open('fa fa-pencil', 'Add New Program'); ?>
		
		<?php echo text_field([
		                    'name' => 'program_title',
		                    'title' => 'Program Title',
		                    'value' => (empty($value['program_title']) === false) ? $value['program_title'] : old('program_title'),
		                    'atts' =>  [
		                      'placeholder' => 'Program Date',
		                      'class' => 'form-control post_type_chack_slug',
		                    ]
		                  ], $error_msg); ?>

		<?php echo textarea_field([
		                    'name' => 'program_desc',
		                    'title' => 'Program description',
		                    'value' => (empty($value['program_desc']) === false) ? $value['program_desc'] : old('program_desc'),
		                    'atts' =>  [
		                      'placeholder' => 'Program Date',
		                      'class' => 'form-control post_type_chack_slug',
		                    ]
		                  ], $error_msg); ?>
		<?php echo  media_uploader([
		            'name' => 'program_icon',
		            'title' => 'Program Icon',
		            'value' => (empty($value['program_icon']) === false) ? $value['program_icon'] : old('program_icon'),
		            'atts' =>  [
		              'class'      => 'btn bg-purple btn-flat media_uploader_active'
		            ]
		            ], $error_msg); ?>

		<?php echo Form::submit('Save', ['class' => 'btn bg-olive btn-flat pull-right']); ?>

		<?php echo heml_card_close(); ?>

      </div>
    </div>
<?php echo Form::close();

	}



  public function post_type_validation($data){
      return Validator::make($data, [
                'program_title'       => 'required|string|max:255',
                'program_desc'        => 'required|string|max:255',
                'program_icon'        => 'required|integer',
            ], [

          'program_title.regex'    => 'The Class Title format is invalid.',
          'program_title.required' => 'The Class Title field is required.',
          'program_title.max'      => 'The Class Title may not be greater than 255 characters.',
          'program_title.string'   => 'The Class Title must be given string.',

          'program_desc.regex'    => 'The Class time format is invalid.',
          'program_desc.required' => 'The Class time field is required.',
          'program_desc.max'      => 'The Class time may not be greater than 255 characters.',
          'program_desc.string'   => 'The Class time must be given string.',

      ]);
  }

  public function post_type_data_save($data, $post_type) {
    $usermodel      = $this->usermodel;

    $current_user   = $usermodel->current_user();

      $id = DB::table('posts')->insertGetId([
        'post_title'   => sanitize_text($data['program_title']),
        'post_content'   => sanitize_text($data['program_desc']),
        'post_author'  => (int)$current_user['id'],
        'post_type'    => sanitize_text($post_type),
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
      ]);

      if ($id) {
        $this->postmodel->update_post_meta($id, 'program_icon', (int)$data['program_icon']);

        return redirect()->route('edit_post_type', [$id, 'program'])->with('success_msg', 'Program create successful.');
      }
      return redirect()->back()->with('error_msg', 'Program create failed.');
  }
  public function post_type_edit_output($data, $error_msg){
      $this->post_type_output(
        route('post_type_update', [$data->id, $data->post_type]), 
        $error_msg, [
          'program_title' => $data->post_title,
          'program_desc' => $data->post_content,
          'post_id' => $data->id,
          'program_icon' => $this->postmodel->get_post_meta($data->id, 'program_icon'),
        ]);
    }


  public function post_type_edit_data_uppdate($data , $post_id, $post_type){
    $usermodel      = $this->usermodel;
    $current_user   = $usermodel->current_user();


      DB::table('posts')
      ->where('id', $post_id)
      ->where('post_type', $post_type)
      ->update([
        'post_title'   => sanitize_text($data['program_title']),
        'post_content'   => sanitize_text($data['program_desc']),
        'post_author'  => (int)$current_user['id'],
        'post_type'    => sanitize_text($post_type),
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
      ]);
        $this->postmodel->update_post_meta($post_id, 'program_icon', (int)$data['program_icon']);


      return redirect()->back()->with('success_msg', 'Program Update successful.');
  }

  public function show_all_post_type_output(){
   ?>
<?php echo heml_card_open('fa fa-user', 'All Class'); ?>

          <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
            tarms-url="<?php echo route('get-all-posts', 'program'); ?>"
            tarms-data='<?php echo json_encode([
                            ['data' => 'post_title'],
                            ['data' => 'post_content'],
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
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
              </tr>
            </tfoot>
          </table>

<?php echo heml_card_close(); ?>

   <?php
  }

  public function get_post_for_datatable($data_query = array()){
      
      $post_query = DB::table('posts');
      $post_query->select('id','post_title', 'post_content');

	$exe_query = $post_query->where('post_type', 'program');


    return DataTables::of($exe_query)     
    ->addColumn('action', function ($post) {
            return '<a href="'.route('edit_post_type', [$post->id, 'program']).'" class="btn bg-purple btn-flat">Edith</a> <a

        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'


            href="'.route('post_type_delete', [$post->id, 'program']).'" class="btn bg-maroon btn-flat margin">Delete</a>';
        })
    ->escapeColumns(['*'])
    ->make(true);

  }

}