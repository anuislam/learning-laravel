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

class add_new_class extends post_type{
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
        'add_new_title'            => 'Add New Class',
        'all_post_title'            => 'All Class',
        'edit_post_title'            => 'Edit Class',
        'page_sub_title'        => 'Class',
      ];
    }
  public function post_content_output($error_msg = ''){
    $this->post_type_output(route('stor_post', ['class-schedule']), $error_msg);
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

<?php echo heml_card_open('fa fa-pencil', 'Page title'); ?>

<?php echo text_field([
                    'name' => 'class_title',
                    'title' => 'Class title',
                    'value' => (empty($value['class_title']) === false) ? $value['class_title'] : old('class_title'),
                    'atts' =>  [
                      'placeholder' => 'Class title',
                      'class' => 'form-control post_type_chack_slug',
                    ]
                  ], $error_msg); ?>

<?php echo text_field([
                    'name' => 'class_time',
                    'title' => 'Class Date',
                    'value' => (empty($value['class_time']) === false) ? $value['class_time'] : old('class_time'),
                    'atts' =>  [
                      'placeholder' => 'Class Date',
                      'class' => 'form-control post_type_chack_slug',
                    ]
                  ], $error_msg); ?>


<?php echo text_field([
                    'name' => 'class_triner',
                    'title' => 'Class triner',
                    'value' => (empty($value['class_triner']) === false) ? $value['class_triner'] : old('class_triner'),
                    'atts' =>  [
                      'placeholder' => 'Class triner',
                      'class' => 'form-control post_type_chack_slug',
                    ]
                  ], $error_msg); ?>

<?php echo  media_uploader([
            'name' => 'class_icon',
            'title' => 'Class Icon',
            'value' => (empty($value['class_icon']) === false) ? $value['class_icon'] : old('class_icon'),
            'atts' =>  [
              'class'      => 'btn bg-purple btn-flat media_uploader_active'
            ]
            ], $error_msg); ?>
<?php echo  select_field([
                    'name' => 'class_cat[]',
                    'title' => 'Class Category',
                    'value' => (empty($value['class_cat']) === false) ? explode(',', $value['class_cat']) : explode(',', old('class_cat')),
                    'atts' =>  [
                        'class' => 'form-control select2', 
                        'style' => 'width: 100%;',
                        'multiple' => 'multiple',
                      ],
                    'items' =>  $this->get_post_type_tarm([
                          'tarm-type' => 'class-cat'
                        ]),
                  ], $error_msg); ?>
<?php echo Form::submit('Save', ['class' => 'btn bg-olive btn-flat pull-right']); ?>

<?php echo heml_card_close(); ?>


      </div>
    </div>
<?php echo Form::close();
  }


  public function post_type_validation($data){
      return Validator::make($data, [
                'class_title'       => 'required|string|max:255',
                'class_time'        => 'required|string|max:255',
                'class_triner'      => 'required|string|max:255',
                'class_icon'        => 'required|integer',
                'class_cat'        => 'required|array',
            ], [

          'class_title.regex'    => 'The Class Title format is invalid.',
          'class_title.required' => 'The Class Title field is required.',
          'class_title.max'      => 'The Class Title may not be greater than 255 characters.',
          'class_title.string'   => 'The Class Title must be given string.',

          'class_time.regex'    => 'The Class time format is invalid.',
          'class_time.required' => 'The Class time field is required.',
          'class_time.max'      => 'The Class time may not be greater than 255 characters.',
          'class_time.string'   => 'The Class time must be given string.',

          'class_triner.regex'    => 'The Class triner format is invalid.',
          'class_triner.required' => 'The Class triner field is required.',
          'class_triner.max'      => 'The Class triner may not be greater than 255 characters.',
          'class_triner.string'   => 'The Class triner must be given string.',

          'post_tags.required'        => 'The Class Category field is required.',
          'post_tags.array'        => 'The Class Category must be given array.',
          'post_tags.*.integer'    => 'The Class Category must be given integer.',


      ]);
  }

  public function post_type_data_save($data, $post_type) {
    $usermodel      = $this->usermodel;

    $current_user   = $usermodel->current_user();
    if (isset($data['class_cat'])) {
      $data['class_cat']      = implode(',', $data['class_cat']);
    }

      $id = DB::table('posts')->insertGetId([
        'post_title'   => sanitize_text($data['class_title']),
        'post_author'  => (int)$current_user['id'],
        'post_type'    => sanitize_text($post_type),
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
      ]);
      if ($id) {
        $this->postmodel->update_post_meta($id, 'class_time', sanitize_text($data['class_time']));
        $this->postmodel->update_post_meta($id, 'class_triner', sanitize_text($data['class_triner']));
        $this->postmodel->update_post_meta($id, 'class_icon', (int)$data['class_icon']);

        $this->postmodel->update_post_meta($id, 'class_cat', sanitize_text($data['class_cat']));
        return redirect()->route('edit_post_type', [$id, 'class-schedule'])->with('success_msg', 'Class create successful.');
      }
      return redirect()->back()->with('error_msg', 'Class create failed.');
  }

  public function post_type_edit_output($data, $error_msg){
      $this->post_type_output(
        route('post_type_update', [$data->id, $data->post_type]), 
        $error_msg, [
          'class_title' => $data->post_title,
          'post_id' => $data->id,
          'class_time' => $this->postmodel->get_post_meta($data->id, 'class_time'),
          'class_triner' => $this->postmodel->get_post_meta($data->id, 'class_triner'),
          'class_icon' => $this->postmodel->get_post_meta($data->id, 'class_icon'),
          'class_cat' => $this->postmodel->get_post_meta($data->id, 'class_cat'),
        ]);
    }


  public function post_type_edit_data_uppdate($data , $post_id, $post_type){
    $usermodel      = $this->usermodel;
    $current_user   = $usermodel->current_user();
    if (isset($data['class_cat'])) {
      $data['class_cat']      = implode(',', $data['class_cat']);
    }

      DB::table('posts')
      ->where('id', $post_id)
      ->where('post_type', $post_type)
      ->update([
        'post_title'   => sanitize_text($data['class_title']),
        'post_author'  => (int)$current_user['id'],
        'post_type'    => sanitize_text($post_type),
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
      ]);
        $this->postmodel->update_post_meta($post_id, 'class_time', sanitize_text($data['class_time']));
        $this->postmodel->update_post_meta($post_id, 'class_triner', sanitize_text($data['class_triner']));
        $this->postmodel->update_post_meta($post_id, 'class_icon', (int)$data['class_icon']);

        $this->postmodel->update_post_meta($post_id, 'class_cat', sanitize_text($data['class_cat']));

      return redirect()->back()->with('success_msg', 'Class Update successful.');
  }



  public function show_all_post_type_output(){
   ?>
<?php echo heml_card_open('fa fa-user', 'All Class'); ?>

          <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
            tarms-url="<?php echo route('get-all-posts', 'class-schedule'); ?>"
            tarms-data='<?php echo json_encode([
                            ['data' => 'post_title'],
                            ['data' => 'class_time'],
                            ['data' => 'class_triner'],
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
                <th>Class Date</th>
                <th>Triner</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Class Date</th>
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

      if (isset($data_query['post_type']) === true) {
          $exe_query = $post_query->where('post_type', $data_query['post_type']);
      }else{
        $exe_query = $post_query->where('post_type', 'class-schedule');
      }
// btn btn-default btn-xs

    return DataTables::of($exe_query)     
    ->addColumn('class_time', function ($post) {

            return $this->postmodel->get_post_meta($post->id, 'class_time');

        })      
    ->addColumn('class_triner', function ($post) {

            return $this->postmodel->get_post_meta($post->id, 'class_triner');

        })   
    ->addColumn('action', function ($post) {
            return '<a href="'.route('edit_post_type', [$post->id, 'class-schedule']).'" class="btn bg-purple btn-flat">Edith</a> <a

        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'


            href="'.route('post_type_delete', [$post->id, 'class-schedule']).'" class="btn bg-maroon btn-flat margin">Delete</a>';
        })
    ->escapeColumns(['*'])
    ->make(true);

  }



}
