<?php

namespace App\registerModel;
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

class page extends post_type{


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
        'add_new_title'            => 'Add New Page',
        'all_post_title'            => 'All Pages',
        'edit_post_title'            => 'Edit Page',
        'page_sub_title'        => 'Blog Page',
      ];
    }



  public function post_content_output($error_msg = ''){
    $this->post_type_output(route('stor_post', ['page']), $error_msg);
  } 



  public function post_type_edit_output($data, $error_msg){
      $this->post_type_output(
        route('post_type_update', [$data->id, $data->post_type]), 
        $error_msg, [
          'post_title' => $data->post_title,
          'post_id' => $data->id,
          'post_slug' => $data->post_slug,
          'post_content' => $data->post_content,
          'post_status' => $data->status,
          'page_template' => $this->postmodel->get_post_meta($data->id, 'page_template')
        ]);
    }



  public function post_type_validation($data){
      return Validator::make($data, [
                'post_title'      => 'required|string|max:255',
                'post_content'    => 'nullable|max:10000',
                'post_status'     => 'required|string',
                'page_template'   => 'required|string|max:100',
            ], [
          'post_title.regex'    => 'The Page Title format is invalid.',
          'post_title.required' => 'The Page Title field is required.',
          'post_title.max'      => 'The Page Title may not be greater than 255 characters.',
          'post_title.string'   => 'The Page Title must be given string.',

          'post_content.max'   => 'The Page content may not be greater than 10000 characters.',

          'post_status.required'    => 'The Page Status field is required.',
          'post_status.string'       => 'The Page Status must be given string.',
      ]);
  }


  public function post_type_data_process($request, $post_type){
    $this->post_type_validation($request->all())->validate();
    do_action('page_meta_validation', $request->all());
    return $this->post_type_data_save($request, $post_type);
  }



  public function post_type_edit_data_process($request, $post_type, $post_id){
    $this->post_type_edit_validation($request->all(), $post_id)->validate();
    do_action('page_meta_validation', $request->all());
    return $this->post_type_edit_data_uppdate( $request, $post_id, $post_type);
  }



  public function post_type_data_save($data, $post_type) {
    $usermodel      = $this->usermodel;
    $current_user   = $usermodel->current_user();
    $data['post_slug'] = $this->postmodel->slug_format($data['post_title']);
      $id = DB::table('posts')->insertGetId([
        'post_title'   => sanitize_text($data['post_title']),
        'status'  => sanitize_text($data['post_status']),
        'post_slug'    => sanitize_text($data['post_slug']),
        'post_author'  => (int)$current_user['id'],
        'post_content' => Purifier::clean($data['post_content'], array('AutoFormat.AutoParagraph' => false)),
        'post_type'    => sanitize_text($post_type),
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
      ]);
      if ($id) {
        $this->postmodel->update_post_meta($id, 'page_template', sanitize_text($data['page_template']));
        do_action('page_meta_save', [
        'post_id' => $id,
        'data' => $data,
      ]);
        return redirect()->route('edit_post_type', [$id, 'page'])->with('success_msg', 'Page create successful.');
      }
      return redirect()->back()->with('error_msg', 'Page create failed.');
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
        'status'  => sanitize_text($data['post_status']),
        'post_slug'  => sanitize_text($data['post_slug']),
        'post_content' => Purifier::clean($data['post_content'], array('AutoFormat.AutoParagraph' => false)),
        'updated_at' => new \DateTime(),
      ]);

      $this->postmodel->update_post_meta($post_id, 'page_template', sanitize_text($data['page_template']));
      do_action('page_meta_save', [
        'post_id' => $post_id,
        'data' => $data,
      ]);

      return redirect()->back()->with('success_msg', 'Page Update successful.');
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
                    'name' => 'post_title',
                    'title' => 'Page title',
                    'value' => (empty($value['post_title']) === false) ? $value['post_title'] : old('post_title'),
                    'atts' =>  [
                      'placeholder' => 'Enter Page title',
                      'aria-describedby' => 'Enter Page title', 
                      'class' => 'form-control post_type_chack_slug',
                    ]
                  ], $error_msg);



    if (empty($value) === false) {

      post_type_slug_checker(route('chack-slug'), $value['post_slug'], [
          'title' => 'Page slug',
          'atts'  => [
            'data-post-id' => $value['post_id']
          ]
      ]);

    }


?>

<?php echo heml_card_close(); ?>

<?php echo heml_card_open('fa fa-pencil', 'Page Content'); ?>

  <?php 
        textarea_editor([
            'name' => 'post_content',
            'title' => 'Page content',
            'value' => (empty($value['post_content']) === false) ? $value['post_content'] : old('post_content'),
            'atts' =>  [
              'style' => 'min-height:600px;'
              ]
          ], $error_msg); 
    ?>    

<?php echo heml_card_close(); ?>

<?php do_action('page_meta', $error_msg); ?>

      </div>


    <div class="col-md-4">
      <?php echo heml_card_open('fa fa-pencil', 'Page publish'); ?>
          <?php echo  select_field([
                    'name' => 'post_status',
                    'title' => 'Page status',
                    'value' => (empty($value['post_status']) === false) ? $value['post_status'] : old('post_status'),
                    'atts' =>  [
                        'aria-describedby' => 'Page', 
                        'class' => 'form-control select2', 
                        'style' => 'width: 100%;',
                      ],
                    'items' =>  [
                      '1' => 'Publish',
                      '2' => 'Trush',
                    ],
                  ], $error_msg); 
                  $page_template = (empty($value['page_template']) === false) ? $value['page_template'] : old('page_template');                  ?>
            
      <?php echo registered_page_template($page_template, $error_msg); ?>

      <?php echo Form::submit('Publish', ['class' => 'btn bg-olive btn-flat pull-right']); ?>

       <?php echo heml_card_close(); ?>
  
        <?php do_action('page_meta_side', $error_msg); ?>

    </div>

    </div>
<?php echo Form::close();
  }






  public function get_post_for_datatable($data_query = array()){
      
      $post_query = DB::table('posts');
      $post_query->select('id', 'post_slug', 'post_title', 'post_content', 'status', 'post_type', 'post_author', 'created_at');

      if (isset($data_query['author']) === true) {
         $post_query->where('post_author', $data_query['author']);
      }
      if (isset($data_query['status']) === true) {
         $post_query->where('status', $data_query['status']);
      }

      if (isset($data_query['post_type']) === true) {
          $exe_query = $post_query->where('post_type', $data_query['post_type']);
      }else{
        $exe_query = $post_query->where('post_type', 'post');
      }
// btn btn-default btn-xs
    return DataTables::of($exe_query)    
    ->addColumn('post_author', function ($post) {
      $author = $this->usermodel->get_user($post->post_author);
            if ($author) {
              return '<a href="'.route('user.edit', $author->id).'" class="label label-info">'.$author->fname.' '.$author->lname.'</a>';
            }

        })   
    ->addColumn('status', function ($post) {

            return format_status_tag($post->status, [
              'success' => 1,
              'warning' => 0,
              'danger'  => 2,
            ]);

        })   
    ->addColumn('created_at', function ($post) {
            return '<small class="label label-info">'.Carbon\Carbon::parse($post->created_at)->format('Y/m/d - h:i').'</small>';
        })
    ->addColumn('action', function ($post) {
            return '<a href="'.route('edit_post_type', [$post->id, $post->post_type]).'" class="btn bg-purple btn-flat">Edith</a>
              <a target="_blank" href="" class="btn bg-navy btn-flat margin">View</a>
             <a

        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'


            href="'.route('post_type_delete', [$post->id, $post->post_type]).'" class="btn bg-maroon btn-flat">Delete</a>';
        })
    ->escapeColumns(['*'])
    ->make(true);

  }





  public function show_all_post_type_output(){
   ?>
<?php echo heml_card_open('fa fa-user', 'All page'); ?>

          <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
            tarms-url="<?php echo route('get-all-posts', 'page'); ?>"
            tarms-data='<?php echo json_encode([
                            ['data' => 'post_title'],
                            ['data' => 'post_author'],
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
                <th>Title</th>
                <th>Author</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
              </tr>
            </tfoot>
          </table>

<?php echo heml_card_close(); ?>

   <?php
  }

}
