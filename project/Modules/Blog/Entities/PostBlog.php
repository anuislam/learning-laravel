<?php

namespace Modules\Blog\Entities;

use Form;
use App\TarmModel;
use App\UserPermission;
use Auth;
use Input;
use App\UserModel;
use App\mediaModel;
use App\Post;
use App\post_type;
use Image;
use Validator;
use App\BlogPost;
use DB;
use Purifier;
use DataTables;
use Carbon;

class PostBlog extends post_type{

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
            'add_new_title'            => 'Add New Post',
            'all_post_title'            => 'All Posts',
            'edit_post_title'            => 'Edit Post',
            'page_sub_title'        => 'Blog Page',
            'capability'            => [
                  'edith_post'          => 'edith_post', 
                  'edith_others_post'  => 'edith_others_post',  
                  'read_post'          => 'read_post', 
                  'read_others_post'   => 'read_others_post', 
                  'delete_post'        => 'delete_post', 
                  'delete_others_post' => 'delete_others_post', 
                  'create_posts'       => 'create_posts', 
            ],

          ];
    }


    public function get_post_type_tarm(array $data){
      $tarm_data = $this->tarmmodel->get_tarm_query($data);
      $ret_data = [];
      if ($tarm_data) {
        foreach ($tarm_data as $value) {
        $value = json_decode(json_encode($value),true);
         $ret_data[$value['id']] = $value['tarm-name'];
        }
      }
      return count($ret_data) > 0 ? $ret_data : [] ;
    }


  public function post_content_output($error_msg = ''){
    $this->post_type_output(route('stor_post', ['post']), $error_msg);
  } 

  public function post_type_edit_output($data, $error_msg){
    $post_category = $this->postmodel->get_post_meta($data->id, 'post_category');
    $post_tags = $this->postmodel->get_post_meta($data->id, 'post_tags');
    $post_image = $this->postmodel->get_post_meta($data->id, 'post_image');
    $this->post_type_output(
      route('post_type_update', [$data->id, $data->post_type]), 
      $error_msg, [
        'post_title' => $data->post_title,
        'post_slug' => $data->post_slug,
        'post_id' => $data->id,
        'post_content' => $data->post_content,
        'status' => $data->status,
        'post_tags' => explode(',', $post_tags),
        'post_category' => explode(',', $post_category),
        'post_image' => $post_image,
        'post_bg_image' => $this->postmodel->get_post_meta($data->id, 'post_bg_image'),
      ]);
  }


  public function post_type_output( $route, $error_msg , $value = '' ){
    if (empty($value) === false) {
      $method = 'PATCH';
    }else{
      $method = 'POST';
    }
    echo Form::open(['url' =>  $route, 'method' => $method]);
?>


    <div class="row">
      <div class="col-md-8">

<?php echo heml_card_open('fa fa-pencil', 'Post title'); ?>

<?php echo text_field([
                    'name' => 'post_title',
                    'title' => 'Post title',
                    'value' => (empty($value['post_title']) === false) ? $value['post_title'] : old('post_title'),
                    'atts' =>  [
                      'placeholder' => 'Enter post title',
                      'aria-describedby' => 'Enter post title', 
                      'class' => 'form-control post_type_chack_slug',
                    ]
                  ], $error_msg);

    if (empty($value) === false) {

      post_type_slug_checker(route('chack-slug'), $value['post_slug'], [
          'title' => 'Post slug',
          'atts'  => [
            'data-post-id' => $value['post_id']
          ]
      ]);

    }
?>

<?php echo heml_card_close(); ?>

<?php echo heml_card_open('fa fa-pencil', 'Post Content'); ?>

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


<?php echo do_action('post_meta', $error_msg); ?>

      </div>


    <div class="col-md-4">
      <?php echo heml_card_open('fa fa-pencil', 'Post publish'); ?>
                <?php echo  select_field([
                    'name' => 'status',
                    'title' => 'Post status',
                    'value' => (empty($value['status']) === false) ? $value['status'] : old('status'),
                    'atts' =>  [ 
                        'class' => 'form-control select2', 
                        'style' => 'width: 100%;',
                      ],
                    'items' =>  [                      
                      '0' => 'Pending',
                      '1' => 'Publish',
                      '2' => 'Trush',
                      '3' => 'Poned',
                    ],
                  ], $error_msg); ?>

                  <?php echo Form::submit('Publish', ['class' => 'btn bg-olive btn-flat pull-right']); ?>

              <?php echo heml_card_close(); ?>

      <?php echo heml_card_open('fa fa-pencil', 'Post tag'); ?>
                <?php echo  select_field([
                    'name' => 'post_tags[]',
                    'title' => 'Post Tags',
                    'value' => (empty($value['post_tags']) === false) ? $value['post_tags'] : old('post_tags'),
                    'atts' =>  [
                        'aria-describedby' => 'Userrool', 
                        'class' => 'form-control select2', 
                        'style' => 'width: 100%;',
                        'multiple' => 'multiple',
                      ],
                    'items' =>  $this->get_post_type_tarm([
                          'tarm-type' => 'tags'
                        ]),
                  ], $error_msg); ?>
              <?php echo heml_card_close(); ?>

      <?php echo heml_card_open('fa fa-pencil', 'Post category'); ?>
                <?php echo  select_field([
                    'name' => 'post_category[]',
                    'title' => 'Category',
                    'value' => (empty($value['post_category']) === false) ? $value['post_category'] : old('post_category'),
                    'atts' =>  [
                        'aria-describedby' => 'Userrool', 
                        'class' => 'form-control select2', 
                        'style' => 'width: 100%;',
                        'multiple' => 'multiple',
                      ],
                    'items' =>  $this->get_post_type_tarm([
                          'tarm-type' => 'category'
                        ]),
                  ], $error_msg); ?>
              <?php echo heml_card_close(); ?>

              <?php echo heml_card_open('fa fa-pencil', 'Post image'); ?>
                <?php echo  media_uploader([
                'name' => 'post_image',
                'title' => 'Upload Image',
                'value' => (empty($value['post_image']) === false) ? $value['post_image'] : old('post_image'),
                'atts' =>  [
                'class'      => 'btn bg-purple btn-flat media_uploader_active'
                ]
                ], $error_msg); ?>
              <?php echo heml_card_close(); ?>

        <?php echo heml_card_open('fa fa-picture-o', 'Post Background Image'); ?>

        <?php echo  media_uploader([
            'name' => 'post_bg_image',
            'title' => 'Upload Image',
            'value' => (empty($value['post_bg_image']) === false) ? $value['post_bg_image'] : old('post_bg_image'),
            'atts' =>  [
              'class'      => 'btn bg-purple btn-flat media_uploader_active'
               ]
          ], $error_msg); ?>

        <?php echo heml_card_close(); ?>


<?php echo do_action('post_meta_side', $error_msg); ?>
    </div>

    </div>
<?php echo Form::close();
  }


  public function post_type_data_process($request, $post_type){
    $this->post_type_validation($request->all())->validate();    
    do_action('post_validation', $request->all());    
    return $this->post_type_data_save($request, $post_type);
  }

  public function post_type_validation($data){
      return Validator::make($data, [
                'post_title'      => 'required|string|max:255|',
                'post_content'      => 'nullable|max:10000',
                'status' => 'required|integer',

                'post_tags' => 'nullable|array',
                'post_tags.*' => 'nullable|integer',

                'post_category' => 'nullable|array',
                'post_category.*' => 'nullable|integer',
                'post_image' => 'nullable|integer',
                'post_bg_image' => 'nullable|integer',
            ], [
          'post_title.required' => 'The Post Title field is required.',
          'post_title.max'      => 'The Post Title may not be greater than 255 characters.',
          'post_title.string'   => 'The Post Title must be given string.',

          'post_content.max'   => 'The Post content may not be greater than 10000 characters.',

          'integer.required'    => 'The Post Status field is required.',
          'integer.string'       => 'The Post Status must be given string.',

          'post_tags.array'        => 'The Post tag must be given array.',
          'post_tags.*.integer'    => 'The Post tag must be given integer.',

          'post_category.array'        => 'The Post category must be given array.',
          'post_category.*.integer'    => 'The Post category must be given integer.',

          'post_image.integer'        => 'The Post Image must be given integer.',
      ]);
  }


  public function post_type_data_save($data, $post_type) {
    $usermodel      = $this->usermodel;
    $current_user   = $usermodel->current_user();

    $data['post_slug'] = $this->postmodel->slug_format($data['post_title']);
    if (isset($data['post_tags'])) {
      $data['post_tags']      = implode(',', $data['post_tags']);
    }
    if (isset($data['post_category'])) {
      $data['post_category']  = implode(',', $data['post_category']);
    }   

      $id = DB::table('posts')->insertGetId([
        'post_title'   => sanitize_text($data['post_title']),
        'status'  => (int)$data['status'],
        'post_slug'    => sanitize_text(strtolower($data['post_slug'])),
        'post_author'  => (int)$current_user['id'],
        'post_content' => Purifier::clean($data['post_content'], array(
          'AutoFormat.AutoParagraph' => false,
          'HTML.Nofollow' => true,
        )),
        'post_type'    => sanitize_text($post_type),
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
      ]);
      if ($id) {
        $this->postmodel->update_post_meta($id, 'post_image', (int)$data['post_image']);
        $this->postmodel->update_post_meta($id, 'post_bg_image', (int)$data['post_bg_image']);
        $this->postmodel->update_post_meta($id, 'post_tags', sanitize_text($data['post_tags'] ));
        $this->postmodel->update_post_meta($id, 'post_category', sanitize_text($data['post_category']));
        do_action('post_save', $id);
        return redirect()->route('edit_post_type', [$id, 'post'])->with('success_msg', 'Post create successful.');
      }
      return redirect()->back()->with('error_msg', 'Failed to create Post.');
  }


  public function post_type_edit_data_process($request, $post_type, $post_id){
    $this->post_type_edit_validation($request->all(), $post_id)->validate();
    do_action('post_validation', $request->all());
    return $this->post_type_edit_data_uppdate( $request, $post_id, $post_type);
  }

  public function post_type_edit_validation($request , $post_id){
      return $this->post_type_validation($request);
  }

  public function post_type_edit_data_uppdate($data , $post_id, $post_type){
    $usermodel      = $this->usermodel;
    $current_user   = $usermodel->current_user();
    $data['post_slug'] = $this->postmodel->slug_format($data['post_slug'], $post_id);
    if (isset($data['post_tags'])) {
      $data['post_tags']      = implode(',', $data['post_tags']);
    }
    if (isset($data['post_category'])) {
      $data['post_category']  = implode(',', $data['post_category']);
    }
      DB::table('posts')
      ->where('id', $post_id)
      ->where('post_type', $post_type)
      ->update([
        'post_title'   => sanitize_text($data['post_title']),
        'status'        => (int)$data['status'],
        'post_slug'    => sanitize_text($data['post_slug']),
        'post_content' => Purifier::clean($data['post_content'], array(
          'AutoFormat.AutoParagraph' => false,
          'HTML.Nofollow' => true,
        )),
        'updated_at' => new \DateTime(),
      ]);

      $this->postmodel->update_post_meta($post_id, 'post_bg_image', (int)$data['post_bg_image']);
      $this->postmodel->update_post_meta($post_id, 'post_image', (int)$data['post_image']);
      $this->postmodel->update_post_meta($post_id, 'post_tags', sanitize_text($data['post_tags'] ));
      $this->postmodel->update_post_meta($post_id, 'post_category', sanitize_text($data['post_category']));
      do_action('post_save', $post_id);
      return redirect()->back()->with('success_msg', 'Post Update successful.');

  }




  public function show_all_post_type_output(){
   ?>
<?php echo heml_card_open('fa fa-user', 'All posts'); ?>

          <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
            tarms-url="<?php echo route('get-all-posts', 'post'); ?>"
            tarms-data='<?php echo json_encode([
                            ['data' => 'post_title'],
                            ['data' => 'post_author'],
                            [
                              'data' => 'category',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                            ],
                            [
                              'data' => 'tags',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                            ],
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
                <th>Category</th>
                <th>Tags</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Tags</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </tfoot>
          </table>

<?php echo heml_card_close(); ?>

   <?php
  }


  public function prepare_delete_post($id, $post_type){
    $dara = DB::table('posts')->where('id', $id)->where('post_type', $post_type)->delete();
    if ($dara) {
      DB::table('post_meta')->where('post_id', $id)->delete();
      return redirect()->back()->with('success_msg', 'Delete Successful.');
    }
    return redirect()->back()->with('error_msg', 'Delete Failed.' );
  }



  public function get_post_for_datatable($data_query = array()){
      
      $post_query = DB::table('posts');
      $post_query->select('id','post_title', 'post_slug', 'post_content', 'status', 'post_type', 'post_author', 'created_at');

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
      $exe_query = $exe_query->orderBy('id', 'desc');
// btn btn-default btn-xs
    return DataTables::of($exe_query)    
    ->addColumn('post_author', function ($post) {
      $author = $this->usermodel->get_user($post->post_author);
            if ($author) {
              return '<a href="'.route('user.edit', $author->id).'" class="label label-info">'.$author->fname.' '.$author->lname.'</a>';
            }

        })   
    ->addColumn('status', function ($post) {


          //return (post_is_trush($post->status) === true) ? 'yes' : 'no' ;

            return format_status_tag($post->status, [
              'info'    => '3',
              'success' => '1',
              'warning' => '0',
              'danger'  => '2',
            ]);

        })   
    ->addColumn('category', function ($post) {
            $meta = $this->postmodel->get_post_meta( $post->id, 'post_category' );
            $ret_tarm = '';
            if ($meta) {
              $meta = explode(',', $meta);
              if (is_array($meta)) {
                foreach ($meta as $value) {
                  $tarm = $this->tarmmodel->get_tarms($value);
                  if ($tarm) {
                    $chack_tarm = json_decode(json_encode($tarm), true);
                    $ret_tarm .= '<a style="margin:0 3px;" class="btn btn-default btn-xs" href="'.route('edit-tarm', $chack_tarm['id']).'">'.$chack_tarm['tarm-name'].'</a>';
                  }
                }
              }
            }
            return $ret_tarm;

        })   
    ->addColumn('tags', function ($post) {
            $meta = $this->postmodel->get_post_meta( $post->id, 'post_tags' );

            $ret_tarm = '';
            if ($meta) {
              $meta = explode(',', $meta);
              if (is_array($meta)) {
                foreach ($meta as $value) {
                  $tarm = $this->tarmmodel->get_tarms($value);
                  if ($tarm) {
                    $chack_tarm = json_decode(json_encode($tarm), true);
                    $ret_tarm .= '<a style="margin:0 3px;" class="btn btn-default btn-xs" href="'.route('edit-tarm', [$chack_tarm['id'], 'tags']).'">'.$chack_tarm['tarm-name'].'</a>';
                  }
                }
              }
            }
            return $ret_tarm;

        }) 
    ->addColumn('created_at', function ($post) {
            return '<small class="label label-info">'.Carbon\Carbon::parse($post->created_at)->format('Y/m/d - h:i').'</small>';
        })
    ->addColumn('action', function ($post) {
            return '<a href="'.route('edit_post_type', [$post->id, $post->post_type]).'" class="btn bg-purple btn-flat">Edith</a> 
              <a target="_blank" href="'.route("single_post", $post->post_slug).'" class="btn bg-navy btn-flat margin">View</a>
            <a

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




}
