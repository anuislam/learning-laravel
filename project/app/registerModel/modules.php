<?php

namespace App\registerModel;

use App\TarmModel;
use App\mediaModel;
use App\admin_page;
use App\post;
use Form;
use Auth;
use Validator;
use DB;
use Purifier;
use App\options;
use Shortcode;
use Module;

class modules extends admin_page{

    public function page_setting(){
    	return [
    		'page_title' => 'Modules',
    		'page_sub_title' => 'Settings',
    		'capability' => 'manage_option',
    	];
    }

    public function page_content_output($error_msg = ''){

    	?>
<?php echo heml_card_open('fa fa-plug', 'Modules'); ?>

              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Status</th>
                  </tr>              
                </thead>
                <tbody>
  <?php $modules = $this->get_modulelist();

    if (is_array($modules) === true) {
      foreach ($modules as $key => $value) {
          if (strtolower(@$value['details']['type']) == 'module') {
?>
            <tr>
              <td><?php echo @$value['details']['title']; ?></td>
              <td><?php echo @$value['details']['author']; ?></td>
              <td><?php echo @$value['details']['description']; ?></td>
              <td><span class="label label-default"><?php echo @$value['details']['type']; ?></span></td>
              <td>
                <?php echo Form::open(['url' =>  route('option-update', 'modules'), 'method' => 'PUT' , 'style' => 'display: inline-block;']); ?>
                  <?php echo Form::hidden('activatea_module', $value['name']); ?>
                  <?php
                    $btn_name = '';
                    if (@$value['details']['config'] === 1) {
                     $btn_name = 'Uninstall';
                    }else{
                      $btn_name = 'Install';
                    }
                  ?>
                  <?php echo Form::submit($btn_name, ['class' => 'btn bg-olive margin']); ?>
                <?php echo Form::close(); ?>
                <a
                onclick="data_modal(this)" 
                data-title="Ready to Delete?"
                data-message='Are you sure you want to delete?'
                cancel_text="Cancel"
                submit_text="Delete"
                data-type="post"
                data-parameters='{"_token":"<?php echo csrf_token(); ?>", "_method": "PUT", "delete_module": "<?php echo $value['name']; ?>"}'
                href="<?php echo route('option-update', 'modules'); ?>" class="btn bg-maroon margin">Delete</a>


              </td>
            </tr>
<?php
          }
      }
    }

   ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Status</th>
                  </tr>  
                </tfoot>
              </table>

<?php echo heml_card_close(); ?>
    	<?php
    }


    public function option_validation($data){
      return Validator::make($data, [
                'post_title'      => '',
            ]
        );
    }

    public function option_update($data){
      if (empty($data['activatea_module']) === false) {
        $module = (string)$data['activatea_module'];        
        if (Module::has($module)) {
          $module = Module::find($module);
          $msg = '';
          $module_check = $this->get_modules_details($module);
            if ($module_check['config'] === 1) {
             do_action('module_deactive_'.$module->getName(), $module);
             $module->disable();
             $msg = 'Module deactivated';
            }else{
              do_action('module_active_'.$module->getName(), $module);
              $module->enable();
              $msg = 'Module activated';              
            }
          return redirect()->back()->with('success_msg', $msg);
        }
      }else if (empty($data['delete_module']) === false) {
        $module = (string)$data['delete_module'];        
        if (Module::has($module)) {
          $module = Module::find($module);          
          do_action('module_delete_'.$module->getName(), $module);
          $module->delete();
          return redirect()->back()->with('success_msg', 'Module Delete Successful.');
        }
      }else{
        return false;
      }
    }

    public function get_modulelist(){
      $module = Module::all();
      $module = json_decode(json_encode($module), true);
      $dara = [];
      if (is_array($module)) {
         foreach ($module as $key => $value) {
             $mod = Module::find($key);
             $dara[] = [
                  'name'    => $mod->getName(),
                  'path'    => $mod->getPath(),
                  'details' => $this->get_modules_details($mod),
              ];
         }
      }
      return $dara;
    }

    public function get_modules_details($path) {      
      $data = $path->json('composer.json');      
      $config = $path->json('module.json');
      $retdata = [];
      $retdata['title']       = @$data->title;
      $retdata['description'] = @$data->description;
      $retdata['author']      = @$data->authors[0]['name'];
      $retdata['email']       = @$data->authors[0]['email'];
      $retdata['type']        = @$data->type;
      $retdata['config']      = (int)$config->active;
      return $retdata;
    }
}
