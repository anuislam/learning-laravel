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
use Html;

class themeManagement extends admin_page{

    public function page_setting(){
    	return [
    		'page_title' => 'Theme',
    		'page_sub_title' => 'Management',
    		'capability' => 'manage_option',
    	];
    }

    public function page_content_output($error_msg = ''){
    // //$mod = Module::find('Gymwebsite');  
    // dd(module_active('Gymwebsite'));
    	?>  
      <div class="row">
        <?php $theme = $this->get_theme_list(); ?>
        <?php if (is_array($theme)): ?>
            <?php foreach ( $theme as $tkey => $tvalue) : ?>
                <?php if (strtolower(@$tvalue['composer']->type) == 'theme'): ?>
                <div class="col-md-3">
                  <?php echo Form::open(['url' =>  route('option-update', 'theme'), 'method' => 'PUT']); ?>
                  <?php echo Form::hidden('theme_name', $tvalue['name']); ?>
                  <?php echo heml_card_open('fa', @$tvalue['composer']->title); ?>
                    <div class="row">
                        <div class="col-md-12 theme_manage_height">     
                            <?php echo Html::image(Module::asset($tvalue['name'].':'.@$tvalue['composer']->thumbnail), @$tvalue['composer']->title, array('class' => 'img-thumbnail')); ?>         
                            <p><?php echo @$tvalue['composer']->description; ?></p>
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px;">
                        <div class="col-md-12">

                <a
                onclick="data_modal(this)" 
                data-title="Ready to Delete?"
                data-message='Are you sure you want to delete?'
                cancel_text="Cancel"
                submit_text="Delete"
                data-type="post"
                data-parameters='{"_token":"<?php echo csrf_token(); ?>", "_method": "PUT", "delete": "Delete" , "theme_name": "<?php echo $tvalue['name']; ?>"}'
                href="<?php echo route('option-update', 'theme'); ?>" class="btn bg-maroon btn-flat pull-left">Delete</a>

                            <input name="active" type="submit" class="btn bg-olive btn-flat pull-right" value="<?php echo ((int)$tvalue['module']->active === 0) ? 'Install' : 'Unisntall' ;  ?>">
                        </div>
                    </div>
                  <?php echo heml_card_close(); ?> 
                  <?php echo Form::close(); ?>
                </div>
                <?php endif ?>
            <?php endforeach; ?>
        <?php endif ?>
      </div>
    	<?php
    }


    public function option_validation($data){
    	return Validator::make($data, [
                'site_title'        => '',
            ]
        );
    }

    public function option_update($data){
        $msg = '';        
        $option_save = new options('theme');
        $current_theme = get_option('theme');
        $active_theme = false;
        if (empty($current_theme['active_theme']) === false) {
            $active_theme = $current_theme['active_theme'];
        }

        if (empty($data['delete']) === false) {
            $module = (string)$data['theme_name'];  
            if ($active_theme == $module) {
                return redirect()->back()->with('error_msg', 'Please deactive first.');
                die();
            }      
            if (Module::has($module)) {
              $msg = 'Theme Delete Successful.';
              $module = Module::find($module);          
              do_action('module_delete'.$module->getName(), $module);
                $option_save->add_option('active_theme', '');
                $option_save->option_update();
              $module->delete();
              return redirect()->back()->with('success_msg', $msg);
            }            
            $msg = 'Theme Not Exists';
            return redirect()->back()->with('success_msg', $msg);
        }else{
            $module = (string)$data['theme_name'];        
            if (Module::has($module)) {
                $module = Module::find($module);
                $msg = '';
                $module_check = (int)$module->json('module.json')->active;
                if ($module_check === 1) {
                    do_action('theme_deactive_'.$module->getName(), $module);
                    $option_save->add_option('active_theme', '');
                    $option_save->option_update();
                    $module->disable();
                    $msg = 'Theme deactivated';
                }else{
                    do_action('theme_active'.$module->getName(), $module);
                    $option_save->add_option('active_theme', sanitize_text($module->getName()));
                    $option_save->option_update();
                    $module->enable();
                    $msg = 'Theme activated';
                }
            }else{
                $msg = 'Theme Not Exists';
            }
        }
        return redirect()->back()->with('success_msg', $msg);
    }

    public function get_theme_list(){
        $module = Module::all();
        $module = json_decode(json_encode($module), true);
        $data = [];
        $current_theme = get_option('theme');
        if (empty($current_theme['active_theme']) === false) {
            $active_theme = Module::find($current_theme['active_theme']);
            $data[] = [
                  'name'    => $active_theme->getName(),
                  'path'    => $active_theme->getPath(),
                  'module'  => $active_theme->json('module.json'),
                  'composer' => $active_theme->json('composer.json'),
              ];
        }        
        if (is_array($module)) {
             $loop = true;
             foreach ($module as $key => $value) {
                 $mod = Module::find($key);
                 if (empty($current_theme['active_theme']) === false) {
                     if ($current_theme['active_theme'] == $mod->getName()) {
                         $loop = false;
                     }
                 }
                 if ($loop === true) {
                     $data[] = [
                          'name'    => $mod->getName(),
                          'path'    => $mod->getPath(),
                          'module'  => $mod->json('module.json'),
                          'composer' => $mod->json('composer.json'),
                      ];
                      if (strtolower($mod->json('composer.json')->type) == 'theme') {         
                        $mod->disable();
                      }
                 }
                 $loop = true;
             }
        }
        return $data;
    }
}