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

class trainer extends post_type{
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
        'add_new_title'            => 'Add New Trainer',
        'all_post_title'            => 'All Trainer',
        'edit_post_title'            => 'Edit Trainer',
        'page_sub_title'        => 'Trainer'
      ];
    }
  public function post_content_output($error_msg = ''){
    $this->post_type_output(route('stor_post', ['trainer']), $error_msg);
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

<?php echo heml_card_open('fa fa-user', 'Trainer Details'); ?>

<?php echo text_field([
                    'name' => 'trainer_name',
                    'title' => 'Trainer name',
                    'value' => (empty($value['trainer_name']) === false) ? $value['trainer_name'] : old('trainer_name'),
                    'atts' =>  [
                      'placeholder' => 'Trainer name',
                      'class' => 'form-control',
                    ]
                  ], $error_msg); ?>

<?php echo text_field([
                    'name' => 'trainer_title',
                    'title' => 'Trainer title',
                    'value' => (empty($value['trainer_title']) === false) ? $value['trainer_title'] : old('trainer_title'),
                    'atts' =>  [
                      'placeholder' => 'Trainer title',
                      'class' => 'form-control',
                    ]
                  ], $error_msg); ?>

<?php echo textarea_field([
                    'name' => 'trainer_descrption',
                    'title' => 'Trainer descrption',
                    'value' => (empty($value['trainer_descrption']) === false) ? $value['trainer_descrption'] : old('trainer_descrption'),
                    'atts' =>  [
                      'placeholder' => 'Trainer descrption',
                      'class' => 'form-control',
                    ]
                  ], $error_msg); ?>


<?php echo url_field([
                    'name' => 'trainer_facebook',
                    'title' => 'Trainer Facebook',
                    'value' => (empty($value['trainer_facebook']) === false) ? $value['trainer_facebook'] : old('trainer_facebook'),
                    'atts' =>  [
                      'placeholder' => 'Trainer Facebook',
                      'class' => 'form-control',
                    ]
                  ], $error_msg); ?>

<?php echo url_field([
                    'name' => 'trainer_twitter',
                    'title' => 'Trainer twitter',
                    'value' => (empty($value['trainer_twitter']) === false) ? $value['trainer_twitter'] : old('trainer_twitter'),
                    'atts' =>  [
                      'placeholder' => 'Trainer twitter',
                      'class' => 'form-control',
                    ]
                  ], $error_msg); ?>

<?php echo url_field([
                    'name' => 'trainer_instagram',
                    'title' => 'Trainer Instagram',
                    'value' => (empty($value['trainer_instagram']) === false) ? $value['trainer_instagram'] : old('trainer_instagram'),
                    'atts' =>  [
                      'placeholder' => 'Trainer Instagram',
                      'class' => 'form-control',
                    ]
                  ], $error_msg); ?>

<?php echo  media_uploader([
            'name' => 'trainer_avatar',
            'title' => 'Trainer avatar',
            'value' => (empty($value['trainer_avatar']) === false) ? $value['trainer_avatar'] : old('trainer_avatar'),
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
                'trainer_name'            => 'required|string|max:255',
                'trainer_title'           => 'required|string|max:255',
                'trainer_descrption'      => 'required|string|max:1000',
                'trainer_facebook'        => 'required|url',
                'trainer_twitter'         => 'required|url',
                'trainer_instagram'       => 'required|url',
                'trainer_avatar'          => 'required|integer',
            ]);
  }

  public function post_type_data_save($data, $post_type) {
    $usermodel      = $this->usermodel;
    $current_user   = $usermodel->current_user();

      $id = DB::table('posts')->insertGetId([
        'post_title'      => sanitize_text($data['trainer_name']),
        'post_content'    => sanitize_text($data['trainer_descrption']),
        'post_author'     => (int)$current_user['id'],
        'post_type'       => sanitize_text($post_type),
        'created_at'      => new \DateTime(),
        'updated_at'      => new \DateTime(),
      ]);
      if ($id) {
        $this->postmodel->update_post_meta($id, 'trainer_title', sanitize_text($data['trainer_title']));
        $this->postmodel->update_post_meta($id, 'trainer_facebook', sanitize_url($data['trainer_facebook']));
        $this->postmodel->update_post_meta($id, 'trainer_twitter', sanitize_url($data['trainer_twitter']));
        $this->postmodel->update_post_meta($id, 'trainer_instagram', sanitize_url($data['trainer_instagram']));
        $this->postmodel->update_post_meta($id, 'trainer_avatar', (int)$data['trainer_avatar']);

        return redirect()->route('edit_post_type', [$id, 'trainer'])->with('success_msg', 'Trainer add successful.');
      }
      return redirect()->back()->with('error_msg', 'Trainer add failed.');
  }

  public function post_type_edit_output($data, $error_msg){
      $this->post_type_output(
        route('post_type_update', [$data->id, $data->post_type]), 
        $error_msg, [
          'trainer_name' => $data->post_title,
          'trainer_descrption' => $data->post_content,
          'post_id' => $data->id,
          'trainer_title' => $this->postmodel->get_post_meta($data->id, 'trainer_title'),
          'trainer_facebook' => $this->postmodel->get_post_meta($data->id, 'trainer_facebook'),
          'trainer_twitter' => $this->postmodel->get_post_meta($data->id, 'trainer_twitter'),
          'trainer_instagram' => $this->postmodel->get_post_meta($data->id, 'trainer_instagram'),
          'trainer_avatar' => $this->postmodel->get_post_meta($data->id, 'trainer_avatar'),
        ]);
    }


  public function post_type_edit_data_uppdate($data , $post_id, $post_type){
    $usermodel      = $this->usermodel;
    $current_user   = $usermodel->current_user();
      DB::table('posts')
      ->where('id', $post_id)
      ->where('post_type', $post_type)
      ->update([
        'post_title'      => sanitize_text($data['trainer_name']),
        'post_content'    => sanitize_text($data['trainer_descrption']),
        'post_author'  => (int)$current_user['id'],
        'post_type'    => sanitize_text($post_type),
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
      ]);
        $this->postmodel->update_post_meta($post_id, 'trainer_title', sanitize_text($data['trainer_title']));
        $this->postmodel->update_post_meta($post_id, 'trainer_facebook', sanitize_url($data['trainer_facebook']));
        $this->postmodel->update_post_meta($post_id, 'trainer_twitter', sanitize_url($data['trainer_twitter']));
        $this->postmodel->update_post_meta($post_id, 'trainer_instagram', sanitize_url($data['trainer_instagram']));
        $this->postmodel->update_post_meta($post_id, 'trainer_avatar', (int)$data['trainer_avatar']);

      return redirect()->back()->with('success_msg', 'Class Update successful.');
  }



  public function show_all_post_type_output(){
   ?>
<?php echo heml_card_open('fa fa-users', 'All Trainers'); ?>

          <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
            tarms-url="<?php echo route('get-all-posts', 'trainer'); ?>"
            tarms-data='<?php echo json_encode([
                            [
                              'data' => 'trainer_avatar',
                             'searchable' => 'false',
                             'orderable'  => 'false',
                            ],
                            ['data' => 'post_title'],
                            ['data' => 'trainer_title'],
                           [
                             'data'     => 'action',
                             'searchable' => 'false',
                             'orderable'  => 'false',
                           ]
                          ]); ?>'
          >
            <thead>
              <tr>
                <th>Avatar</th>
                <th>Triner</th>
                <th>Title</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Avatar</th>
                <th>Triner</th>
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

      $exe_query = $post_query->where('post_type', 'trainer');
// btn btn-default btn-xs

    return DataTables::of($exe_query)    
    ->addColumn('trainer_avatar', function ($post) {
            return '<img style="width:60px;" src="'.sanitize_url($this->mediaModel->get_image_src('thumbnail', $this->postmodel->get_post_meta($post->id, 'trainer_avatar'))[0]).'" >';
        })  
    ->addColumn('trainer_title', function ($post) {
            return $this->postmodel->get_post_meta($post->id, 'trainer_title');
        })   
    ->addColumn('action', function ($post) {
            return '<a href="'.route('edit_post_type', [$post->id, 'trainer']).'" class="btn bg-purple btn-flat">Edith</a> <a
        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'
            href="'.route('post_type_delete', [$post->id, 'trainer']).'" class="btn bg-maroon btn-flat margin">Delete</a>';
        })
    ->escapeColumns(['*'])
    ->make(true);

  }



}
