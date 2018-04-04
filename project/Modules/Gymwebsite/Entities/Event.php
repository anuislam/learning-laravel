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

class Event extends post_type{
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
        'add_new_title'            => 'Add New Event',
        'all_post_title'            => 'All Events',
        'edit_post_title'            => 'Edit Event',
        'page_sub_title'        => 'Event',
        'capability'          => [
          'edith_post'          => 'manage_option', 
          'edith_others_post'   => 'manage_option',  
          'read_post'           => 'manage_option', 
          'read_others_post'    => 'manage_option', 
          'delete_post'         => 'manage_option', 
          'delete_others_post'  => 'manage_option', 
          'create_posts'        => 'manage_option', 
        ],

      ];
    }
  public function post_content_output($error_msg = ''){
    $this->post_type_output(route('stor_post', ['event']), $error_msg);
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

<?php echo heml_card_open('fa fa-pencil', 'Event title'); ?>

<?php echo text_field([
                    'name' => 'post_title',
                    'title' => 'Event title',
                    'value' => (empty($value['post_title']) === false) ? $value['post_title'] : old('post_title'),
                    'atts' =>  [
                      'placeholder' => 'Event title',
                      'class' => 'form-control',
                    ]
                  ], $error_msg);

    if (empty($value) === false) {

      post_type_slug_checker(route('chack-slug'), $value['post_slug'], [
          'title' => 'Event slug',
          'atts'  => [
            'data-post-id' => $value['post_id']
          ]
      ]);

    }
?>

  <?php
        textarea_editor([
            'name' => 'post_content',
            'title' => 'Description',
            'value' => (empty($value['post_content']) === false) ? $value['post_content'] : old('post_content'),
            'atts' =>  [
              'style' => 'min-height:600px;'
              ]
          ], $error_msg); 
    ?> 

<?php echo heml_card_close(); ?>

      </div>
      <div class="col-md-4">
        <?php echo heml_card_open('fa fa-pencil', 'Event Date'); ?>
        <?php 
        date_range_field([
            'name' => 'event_date',
            'title' => 'Event Date',
            'value' => (empty($value['event_date']) === false) ? $value['event_date'] : old('event_date'),
            'icon' => 'fa fa-calendar',
            'atts' =>  [
                'class' => 'form-control pull-right datepicker',
            ]
            ], $error_msg);
        ?>
        <?php echo Form::submit('Save', ['class' => 'btn bg-olive btn-flat pull-right', 'style' => 'margin: 20px 0 0 0;']); ?>
        <?php echo heml_card_close(); ?>

        <?php echo heml_card_open('fa fa-picture-o', 'Event Image'); ?>

        <?php 

        echo  media_uploader([
            'name' => 'page_bg_image',
            'title' => 'Upload Image',
            'value' => (empty($value['page_bg_image']) === false) ? $value['page_bg_image'] : old('page_bg_image'),
            'atts' =>  [
            'class'      => 'btn bg-purple btn-flat media_uploader_active'
            ]
            ], $error_msg); ?>

        <?php echo heml_card_close(); ?>
      </div>
    </div>
<?php echo Form::close();
  }


  public function post_type_validation($data){
    return Validator::make($data, [
            'post_title'       => 'required|string|max:255',
            'post_content'      => 'required|string|max:100000',
            'event_date'       => 'required|string|date_format:"m/d/Y"',
            'page_bg_image'       => 'required|integer',
        ],
        [
          'post_title.required' => 'The Event Title field is required.',
          'post_title.max'      => 'The Event Title may not be greater than 255 characters.',
          'post_title.string'   => 'The Event Title must be given string.',
          'post_content.max'   => 'The Event content may not be greater than 100000 characters.',
        ]);
  }

  public function post_type_data_save($data, $post_type) {
    $usermodel      = $this->usermodel;
    $current_user   = $usermodel->current_user();
    $data['post_slug'] = $this->postmodel->slug_format($data['post_title']);
      $id = DB::table('posts')->insertGetId([
        'post_title'   => sanitize_text($data['post_title']),
        'post_content'   => Purifier::clean($data['post_content'], array(
          'AutoFormat.AutoParagraph' => false,
          'HTML.Nofollow' => true,
        )),
        'post_author'  => (int)$current_user['id'],
        'post_slug'     => sanitize_text(strtolower($data['post_slug'])),
        'post_type'    => sanitize_text($post_type),
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
      ]);
      if ($id) {
        $this->postmodel->update_post_meta($id, 'event_date', sanitize_text($data['event_date']));
        $this->postmodel->update_post_meta($id, 'page_bg_image', (int)$data['page_bg_image']);
        return redirect()->route('edit_post_type', [$id, 'event'])->with('success_msg', 'Event create successful.');
      }
      return redirect()->back()->with('error_msg', 'Event create failed.');
  }

  public function post_type_edit_output($data, $error_msg){
      $this->post_type_output(
        route('post_type_update', [$data->id, $data->post_type]), 
        $error_msg, [
          'post_title' => $data->post_title,
          'post_id'    => $data->id,
          'post_content'    => $data->post_content,
          'post_slug'    => $data->post_slug,
          'event_date'    => $this->postmodel->get_post_meta($data->id, 'event_date'),
          'page_bg_image'    => $this->postmodel->get_post_meta($data->id, 'page_bg_image'),
        ]);
    }


  public function post_type_edit_data_uppdate($data , $post_id, $post_type){
    $usermodel      = $this->usermodel;
    $current_user   = $usermodel->current_user();
    $data['post_slug'] = $this->postmodel->slug_format($data['post_slug'], $post_id);
      DB::table('posts')
      ->where('id', $post_id)
      ->where('post_type', $post_type)
      ->update([
        'post_title'   => sanitize_text($data['post_title']),
        'post_author'  => (int)$current_user['id'],
        'post_content'   => Purifier::clean($data['post_content'], array(
          'AutoFormat.AutoParagraph' => false,
          'HTML.Nofollow' => true,
        )),
        'post_slug'    => sanitize_text($data['post_slug']),
        'post_type'    => sanitize_text($post_type),
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
      ]);

      $this->postmodel->update_post_meta($post_id, 'page_bg_image', (int)$data['page_bg_image']);
      $this->postmodel->update_post_meta($post_id, 'event_date', sanitize_text($data['event_date']));
      return redirect()->back()->with('success_msg', 'Class Update successful.');
  }



  public function show_all_post_type_output(){
   ?>
<?php echo heml_card_open('fa fa-user', 'All Class'); ?>

          <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
            tarms-url="<?php echo route('get-all-posts', 'event'); ?>"
            tarms-data='<?php echo json_encode([
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
                <th>Title</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Title</th>
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
      $post_query->select('id','post_title');

      $exe_query = $post_query->where('post_type', 'event');
// btn btn-default btn-xs

    return DataTables::of($exe_query) 
    ->addColumn('action', function ($post) {
            return '<a href="'.route('edit_post_type', [$post->id, 'event']).'" class="btn bg-purple btn-flat">Edith</a> <a
        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'

            href="'.route('post_type_delete', [$post->id, 'event']).'" class="btn bg-maroon btn-flat margin">Delete</a>';
        })
    ->escapeColumns(['*'])
    ->make(true);

  }



}
