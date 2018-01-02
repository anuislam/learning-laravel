<?php

namespace App\PostSubModel;
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
use App\menuModel;
use Redirect;


class nav_menu extends post_type{


    private $usermodel = '';
    private $permission = '';
    private $mediaModel = '';
    private $postmodel = '';
    private $tarmmodel = '';
    private $menuitems = [];

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
        'add_new_title'            => 'Add New Menu',
        'all_post_title'            => 'All Menus',
        'edit_post_title'            => 'Edit Menu',
        'page_sub_title'        => 'Nav Menu',
        'capability'          => [
          'edith_post'          => 'manage_option', 
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

    $this->post_type_output(route('stor_post', ['nav-menu']), $error_msg);
    
  } 

  public function post_type_edit_output($data, $error_msg){
    return false;
    }



  public function post_type_validation($data){
    return Validator::make($data, [
                'menu_json_output'      => 'required|string',
                'main_menu_id'              => 'required|integer',
            ],[
          'menu_json_output.required'     => 'Error!',
          'menu_json_output.string'       => 'Error!',
          'main_menu_id.required'       => 'Error!',
          'main_menu_id.integer'       => 'Error!',
      ]);
  }



  public function post_type_data_save($data, $post_type) {
    
    if (empty($data['menu_json_output']) === false) {
      $menuModel = new menuModel();
      $menudata = json_decode($data['menu_json_output']);
      $menudata = json_decode(json_encode($menudata),true);
      $items = array();
      $this->set_up_menu_func($menudata, false);
      if ($menuModel->main_menu_exists($data['main_menu_id'])) {
        if (is_array($this->menuitems)) {
          foreach ($this->menuitems as $meny_key => $menuvalue) {
              DB::table('menu_items')
              ->where('id', (int)$menuvalue['id'])
              ->where('menu_id', (int)$data['main_menu_id'])
              ->update([
                'title' => sanitize_text($menuvalue['title']),
                'url' => sanitize_url($menuvalue['url']),
                'parent_id' => ($menuvalue['parent'] == 'null') ? NULL : (int)$menuvalue['parent'],
                'menu_order' => (int)$meny_key,
              ]);
          }
        }
      }

    }
   return redirect()->back()->with('success_msg', 'Menu Update successful.');
  }


 public function post_type_edit_data_uppdate($data , $post_id, $post_type){
  return false;
 }




public function post_type_output( $route, $error_msg , $value = '' ){
  $menuModel = new menuModel();
 if (empty($value) === false) {
    $method = 'PATCH';
  }else{
    $method = 'POST';
  }

  ?>

    <?php if ($error_msg->has('menu_json_output')) : ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-ban"></i> Error!</h4>
      <!--Opss! Something is wrong.-->
      <?php print_r($error_msg->first('menu_json_output')) ?>
    </div>
    <?php endif; ?>
    <?php if ($error_msg->has('menu_loc')) : ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-ban"></i> Error!</h4>
      <!--Opss! Something is wrong.-->
      <?php print_r($error_msg->first('menu_loc')) ?>
    </div>
    <?php endif; ?>


<?php 
$showdata = false;
$ck_menu = request()->query('menu-id');
if ($ck_menu) {
  if (url_gard('integer', request()->query('menu-id')) === true) {   
   if ($menuModel->main_menu_exists(request()->query('menu-id'))) {
    $showdata = true;
   }
  }
}



if ($showdata === true) {

?>
    <div class="row">
      <div class="col-md-4">
        <?php echo heml_card_open('fa fa-list-ul', 'Add Menu Item'); ?>
          <?php echo Form::open(['url' =>  '#', 'method' => 'POST', 'id' => 'add_nav_menu_item']); ?>
          <?php echo text_field([
                              'name' => 'as-menu-title',
                              'title' => 'Menu Title *',
                              'value' => '',
                              'atts' =>  [
                                'placeholder' => 'Menu title',
                                'aria-describedby' => 'Menu title', 
                                'class' => 'form-control',
                              ]
                            ], $error_msg); ?> 

          <?php echo url_field([
                              'name' => 'as-menu-url',
                              'title' => 'Menu Url *',
                              'value' => '',
                              'atts' =>  [
                                'placeholder' => 'Menu url',
                                'aria-describedby' => 'Menu url', 
                                'class' => 'form-control',
                              ]
                            ], $error_msg); ?>           
          <?php echo Form::submit('Add To Menu', ['class' => 'btn btn-primary pull-left']); ?>
          <?php echo Form::close(); ?>
        <?php echo heml_card_close(); ?>
      </div>
      <div class="col-md-6">
        <?php echo heml_card_open('fa fa-list-ul', 'Menu Structure'); ?>
        <p style="font-size: 12px">Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.</p>

        <?php echo Form::open(['url' =>  $route, 'method' => $method, 'id' => 'add_nav_main_menu']); ?>
          <?php echo Form::hidden( 'main_menu_id', request()->query('menu-id'), ['id' => 'main_menu_id']); ?>
        <div class="dd nestable" id="nestable" >
            <ol class="dd-list">
              <?php echo str_replace('<ol class="dd-list"></ol>', '', $this->echo_admin_navigation_menu(NULL, request()->query('menu-id'))); ?>
            </ol>
            <?php echo Form::hidden( 'menu_json_output', '', ['id' =>  'as-nav-menu-json-output']); ?>
        </div>

          <?php echo Form::submit('Save', ['class' => 'btn btn-primary pull-left']); ?>
          <?php echo Form::close(); ?>
        <?php echo heml_card_close(); ?>
      </div>
    </div>
    <?php
}else{
    ?>
    <div class="row">
      <div class="col-md-8">
        <?php echo heml_card_open('fa fa-list-ul', 'Add Menu'); ?>
          <div class="row">
            <div class="col-md-12">
            <?php echo Form::open(['url' =>  route('add_main_menu'), 'method' => 'PUT', 'id' => 'add_main_menu']); ?>
            <div class="form-group <?php echo $error_msg->has('insert_main_menu') ? 'has-error' : '' ?>">
              <?php echo Form::label( 'insert_main_menu', 'Create a menu', ['class' => 'control-label'] ); ?>
              <div class="input-group input-group-sm">
                <?php echo Form::text(  'insert_main_menu', old('insert_main_menu'), ['class' => 'form-control', 'placeholder' => 'Menu Name'] ); ?>
                <span class="input-group-btn">
                  <?php echo Form::submit('Create', ['class' => 'btn btn-info btn-flat']); ?>
                </span>
              </div>  
              <?php if ($error_msg->has('insert_main_menu')) : ?>
                  <span class="help-block">
                      <strong><?php echo $error_msg->first('insert_main_menu');  ?></strong>
                  </span>
              <?php endif; ?>     
             </div>
             <?php echo Form::close(); ?>  
            </div>
          </div>
        <?php echo heml_card_close(); ?>
      </div>      
    </div>
    
    <div class="row">
      <div class="col-md-8">
        <?php echo heml_card_open('fa fa-list-ul', 'All Menus'); ?>
        <table class="table table-bordered">
          <tr>
            <th style="width: 10px">ID</th>
            <th>Menu Name</th>
            <th style="width: 120px;text-align: center;">Add Menu Items</th>
            <th style="width: 80px;text-align: center;">Action</th>
          </tr>

<?php

  $all_main_menu = $menuModel->get_all_main_menu_for_admin_panel();

  if ($all_main_menu) {
    foreach ($all_main_menu as $main_menukey => $main_menuvalue) {
?>

          <tr>
            <td><?php echo $main_menuvalue->id; ?></td>
            <td><?php echo $main_menuvalue->name; ?></td>
            <td>
              <a href="<?php echo route('create_post_type',['nav-menu', 'menu-id'=>$main_menuvalue->id]); ?>" class="btn bg-purple btn-flat">Add Menu Items</a>
            </td>
            <td>       
                <a 
                  onclick="data_modal(this)" 
                  data-title="Ready to Delete?" 
                  data-message="Are you sure you want to delete this?" 
                  cancel_text="Cancel" 
                  submit_text="Delete" 
                  data-type="post" 
                  data-parameters='{
                     "_token":"<?php echo csrf_token(); ?>",
                     "_method": "DELETE",
                     "menid": "<?php echo $main_menuvalue->id; ?>"
                   }'
                  href="<?php echo route('delete_menu');?>" 
                  class="btn bg-maroon btn-flat">Delete
                </a>
            </td>
          </tr>


<?php
    }
  }

?>

        </table>
        <?php echo heml_card_close(); ?>
      </div>
    </div>
  <?php
}


}






public function get_post_for_datatable($data_query = array()){
 
  return false;

}





public function show_all_post_type_output(){
  return false;
}


public function set_up_menu_func($data, $count = false,  $id = 'null'){
  
  if (is_array($data)) {
    foreach ($data as $mk => $m) {
      if (empty($m['children']) === false) {        
        $this->menuitems[] = [
            'title'   => $m['name'],
            'url'     => $m['url'],
            'parent'  => $id,
            'id'      => $m['id'],
        ];
        $this->set_up_menu_func($m['children'], true, $m['id']);
      }else{    
        $this->menuitems[] = [
            'title'   => $m['name'],
            'url'     => $m['url'],
            'parent'  => $id,
            'id'      => $m['id'],
        ];
      }
    }
  }
}

public function echo_admin_navigation_menu($parent = NULL, int $menu_id = 0){
  $sql = DB::table('menu_items');
  $menu_html = '';
  if (is_null($parent)) {
  $sql = $sql->whereRaw('parent_id IS NULL');
  }else{
    $sql = $sql->where('parent_id', '=', (int)$parent);
  }
  $menu_data = $sql->where('menu_id', '=', (int)$menu_id)->orderBy('menu_order', 'asc')->get();

  if (empty($menu_data) === false) {
    foreach ($menu_data as $key => $value) {
     $menu_html .= '<li class="dd-item" data-id="'.$value->id.'" data-name="'.$value->title.'" data-url="'.$value->url.'" data-new="0" data-deleted="0">
      <div class="dd-handle">'.$value->title.'</div>
        <span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="'.$value->id.'">
          <i class="fa fa-times-circle-o" aria-hidden="true"></i>
        </span>
        <span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="'.$value->id.'">
          <i class="fa fa-pencil" aria-hidden="true"></i>
        </span>';
    $menu_html .= '<ol class="dd-list">'.$this->echo_admin_navigation_menu($value->id, $menu_id).'</ol>';
    $menu_html .= '</li>';
    }
  }
  return $menu_html;

}

}
