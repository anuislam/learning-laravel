<?php

namespace Modules\Slider\Entities;

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

class Slider extends post_type{
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
    }

    public function post_type_setting(){
      return [
        'add_new_title'            	=> 'Add New Slider',
        'all_post_title'            => 'All Slider',
        'edit_post_title'           => 'Edit Slider',
        'page_sub_title'        	=> 'Blog Slider',
        'capability'        		=> [
    		  'edith_post'         => 'manage_option', 
    		  'edith_others_post'  => 'manage_option',  
    		  'read_post'          => 'manage_option', 
    		  'read_others_post'   => 'manage_option', 
    		  'delete_post'        => 'manage_option', 
    		  'delete_others_post' => 'manage_option', 
    		  'create_posts'       => 'manage_option', 
        ],

      ];
    }

	public function post_content_output($error_msg = ''){
    	$this->post_type_output(route('stor_post', ['slider']), $error_msg);
	}	

	public function post_type_edit_output($data, $error_msg){
	    $slider_image = $this->postmodel->get_post_meta($data->id, 'slider_image');
      $slider_url = $this->postmodel->get_post_meta($data->id, 'slider_url');
	    $button_title = $this->postmodel->get_post_meta($data->id, 'button_title');
	    $this->post_type_output(
	      route('post_type_update', [$data->id, $data->post_type]), 
	      $error_msg, [
          	'slider_title' => $data->post_title,
	        'post_id' => $data->id,
	        'slider_url' => $slider_url,
	        'slider_image' => $slider_image,
          'slider_content' => $data->post_content,
	        'button_title' => $button_title,
	      ]);
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
<?php echo heml_card_open('fa fa-sliders', 'Add New Slider'); ?>
	<?php echo text_field([
	                    'name' => 'slider_title',
	                    'title' => 'Slider title',
	                    'value' => (empty($value['slider_title']) === false) ? $value['slider_title'] : old('slider_title'),
	                    'atts' =>  [
	                      'placeholder' => 'Slider title',
	                      'aria-describedby' => 'Slider title', 
	                      'class' => 'form-control',
	                    ]
	                  ], $error_msg); ?>
	<?php echo url_field([
	                    'name' => 'slider_url',
	                    'title' => 'Slider url',
	                    'value' => (empty($value['slider_url']) === false) ? $value['slider_url'] : old('slider_url'),
	                    'atts' =>  [
	                      'placeholder' => 'Slider url',
	                      'aria-describedby' => 'Slider url', 
	                      'class' => 'form-control',
	                    ]
	                  ], $error_msg); ?>
  <?php echo text_field([
                      'name' => 'button_title',
                      'title' => 'Button title',
                      'value' => (empty($value['button_title']) === false) ? $value['button_title'] : old('button_title'),
                      'atts' =>  [
                        'placeholder' => 'Button title',
                        'aria-describedby' => 'Button title', 
                        'class' => 'form-control',
                      ]
                    ], $error_msg); ?>
  <?php echo  textarea_field([
                    'name' => 'slider_content',
                    'title' => 'Slider Description',
                    'value' => (empty($value['slider_content']) === false) ? $value['slider_content'] : old('slider_content'),
                    'atts' =>  [
                      'placeholder' => 'Slider Description', 
                      'aria-describedby' => 'Slider Description', 
                      'class' => 'form-control'
                      ]
                  ], $error_msg);
    ?>

<?php echo Form::submit('Save', ['class' => 'btn bg-olive btn-flat pull-right']); ?>
<?php echo heml_card_close(); ?>
	</div>
	<div class="col-md-4">
<?php echo heml_card_open('fa fa-sliders', 'Slider image'); ?>
<?php echo  media_uploader([
        'name' => 'slider_image',
        'title' => 'Upload Image',
        'value' => (empty($value['slider_image']) === false) ? $value['slider_image'] : old('slider_image'),
        'atts' =>  [
          'class'      => 'btn bg-purple btn-flat media_uploader_active', 
          'cancel_text'    => 'Cancel',
          'submit_text'    => 'Select image',
          'uploader_title'    => 'Upload slider image',
           ]
      ], $error_msg); ?>
<?php echo heml_card_close(); ?>
	</div>
</div>


<?php echo Form::close();
	}


  public function post_type_validation($data){
      return Validator::make($data, [
                'slider_title'      => 'required|string|max:255',
                'slider_url'      	=> 'nullable|url',
                'slider_image'      => 'nullable|integer',
                'slider_content'    => 'nullable|string',
                'button_title'      => 'nullable|string',
            ], [
          'slider_title.required' => 'The Slider Title field is required.',
          'slider_title.max'      => 'The Slider Title may not be greater than 255 characters.',
          'slider_title.string'   => 'The Slider Title must be given string.',
          'slider_content.string'   => 'The Slider content must be given string.',
          'slider_url.url'   	      => 'The Slider url is invalid.',
          'slider_image.integer'      => 'The Slider image is invalid.',
          'button_title.string'   	  => 'The button title must be given string.',
      ]);
  }


  public function post_type_data_save($data, $post_type) {
    $usermodel      = $this->usermodel;
    $current_user   = $usermodel->current_user();
      $id = DB::table('posts')->insertGetId([
        'post_title'   => sanitize_text($data['slider_title']),
        'post_author'  => (int)$current_user['id'],
        'post_content' => sanitize_text($data['slider_content']),
        'post_type'    => sanitize_text($post_type),
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
      ]);
      if ($id) {
      	$this->postmodel->update_post_meta($id, 'slider_image', (int)$data['slider_image']);
        $this->postmodel->update_post_meta($id, 'slider_url', sanitize_url($data['slider_url']));
      	$this->postmodel->update_post_meta($id, 'button_title', sanitize_text($data['button_title']));
        return redirect()->route('edit_post_type', [$id, 'slider'])->with('success_msg', 'Slider create successful.');
      }
      return redirect()->back()->with('error_msg', 'Slider create failed.');
  }

 public function post_type_edit_data_uppdate($data , $post_id, $post_type){
    $usermodel      = $this->usermodel;
    $current_user   = $usermodel->current_user();
      DB::table('posts')
      ->where('id', $post_id)
      ->where('post_type', $post_type)
      ->update([
        'post_title'   => sanitize_text($data['slider_title']),
        'post_content' => sanitize_text($data['slider_content']),
        'updated_at' => new \DateTime(),
      ]);
  	$this->postmodel->update_post_meta($post_id, 'slider_image', (int)$data['slider_image']);
    $this->postmodel->update_post_meta($post_id, 'slider_url', sanitize_url($data['slider_url']));
  	$this->postmodel->update_post_meta($post_id, 'button_title', sanitize_text($data['button_title']));
      return redirect()->back()->with('success_msg', 'Page Update successful.');
 }



  public function get_post_for_datatable($data_query = array()){
      
      $post_query = DB::table('posts');
      $post_query->select('id','post_title', 'post_content',  'post_type', 'updated_at');

      if (isset($data_query['author']) === true) {
         $post_query->where('post_author', $data_query['author']);
      }
      if (isset($data_query['post_status']) === true) {
         $post_query->where('post_status', $data_query['post_status']);
      }

	  $exe_query = $post_query->where('post_type', 'slider');
      $exe_query = $exe_query->orderBy('id', 'desc');
// btn btn-default btn-xs
    return DataTables::of($exe_query)    
    ->addColumn('slider_image', function ($post) {
    	$media_id = $this->postmodel->get_post_meta($post->id, 'slider_image');
    	$media_id = (int)$media_id;
    	$data_image = $this->mediaModel->get_image_src('thumbnail', $media_id);
            return '<img src="'.$data_image[0].'" alt="'.$post->post_title.'">';
        })
    ->addColumn('action', function ($post) {
            return '<a href="'.route('edit_post_type', [$post->id, $post->post_type]).'" class="btn bg-purple btn-flat">Edith</a> <a

        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'


            href="'.route('post_type_delete', [$post->id, $post->post_type]).'" class="btn bg-maroon btn-flat margin">Delete</a>';
        })
    ->escapeColumns(['*'])
    ->make(true);

  }


public function show_all_post_type_output(){
   ?>
<?php echo heml_card_open('fa fa-sliders', 'All Slider'); ?>

          <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
            tarms-url="<?php echo route('get-all-posts', 'slider'); ?>"
            tarms-data='<?php echo json_encode([
                            ['data' => 'slider_image'],
                            ['data' => 'post_title'],
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
                <th>Title</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Actions</th>
              </tr>
            </tfoot>
          </table>

<?php echo heml_card_close(); ?>

   <?php
  }

  public function slider_get_slider(){
    $retdata = [];
    $data = DB::table('posts')->where('post_type', '=', 'slider')->orderBy('id', 'desc')->get();
    if ((count($data) > 0)) {
      foreach ($data as $key => $value) {
        $button_title = $this->postmodel->get_post_meta($value->id, 'button_title');
        if ($button_title === false) {
          $button_title = 'VIEW COLLECTION';
        }
        $retdata[] = [
          'slider_title'    => $value->post_title,
          'slider_content'  => $value->post_content,
          'slider_url'      => $this->postmodel->get_post_meta($value->id, 'slider_url'),
          'slider_image'    => $this->postmodel->get_post_meta($value->id, 'slider_image'),
          'button_title'    => $button_title,
        ];
      }       
    }
    return (count($retdata) > 0) ? $retdata : false ;
  }

}
			