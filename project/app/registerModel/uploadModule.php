<?php

namespace App\registerModel;

use App\admin_page;
use Form;
use Validator;
use Session;
use ZipArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class uploadModule extends admin_page{

    public function page_setting(){
    	return [
    		'page_title' => 'Upload',
    		'page_sub_title' => 'Module',
    		'capability' => 'manage_option',
    	];
    }

    public function page_content_output($error_msg = ''){

if (@Session::get('ziplocation')) {
    $zipfile = Session::get('ziplocation');
    $base = base_path();
    $module_path = $base.'/Modules';
    $zip = new ZipArchive;
    if ($zip->open($zipfile) === TRUE) {
        $zip->extractTo($module_path);
        $zip->close();
        unlink($zipfile);
    }
}



    	?>
<?php echo Form::open(['url' =>  route('option-update', 'upload-module'), 'method' => 'PUT', 'files'=>'true']); ?>

    <div class="row">
      <div class="col-md-8">
      <?php echo heml_card_open('fa fa-file', 'Upload Module'); ?>

        <div class="form-group <?php echo $error_msg->has('module') ? 'has-error' : '' ?>">
          <?php echo Form::label( 'module', 'Upload Plugin' ); ?>
          <?php echo Form::file( 'module' ); ?>
          <p class="help-block">Upload your ZIP file.</p>
          <?php if ($error_msg->has('module')) : ?>
            <span class="help-block">
              <strong><?php echo $error_msg->first('module');  ?></strong>
            </span>
          <?php endif; ?>
        </div>

      <?php echo Form::submit('Upload', ['class' => 'btn bg-olive btn-flat pull-left']); ?> 
      <?php echo heml_card_close(); ?>
	  </div>
	</div>
<?php echo Form::close(); ?>
    	<?php
    }


    public function option_validation($data){
    	return Validator::make($data, [
                'module' => 'required|mimes:zip|max:20048',
            ]
        );
    }

    public function option_update($data){
        $module = Input::file('module');
        $base = base_path();
        $raw_name = $module->getClientOriginalName();
        $public_path = $base.'/public/';
        $module->move($public_path, $raw_name);
        return redirect()->back()
        ->with('success_msg', 'Module Upload Successful.')
        ->with('ziplocation',     $public_path.$raw_name);
    }
}
