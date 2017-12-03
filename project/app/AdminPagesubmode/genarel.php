<?php

namespace App\AdminPagesubmode;

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

class genarel extends admin_page{

    public function page_setting(){
    	return [
    		'page_title' => 'Genarel',
    		'page_sub_title' => 'Settings',
    		'capability' => 'manage_option',
    	];
    }

    public function page_content_output($error_msg = ''){
    	$option = get_option('genarel');
    	?>
<?php echo Form::open(['url' =>  route('option-update', 'genarel'), 'method' => 'PUT']); ?>

    <div class="row">
      <div class="col-md-8">
<?php echo heml_card_open('fa fa-user', 'All page'); ?>

<?php echo text_field([
                    'name' => 'post_title',
                    'title' => 'Page title',
                    'value' => (isset($option['post_title'])) ? $option['post_title'] : '' ,
                    'atts' =>  [
                      'placeholder' => 'Enter Page title',
                      'aria-describedby' => 'Enter Page title', 
                      'class' => 'form-control post_type_chack_slug',
                    ]
                  ], $error_msg); ?>

<?php echo text_field([
                    'name' => 'content',
                    'title' => 'Page title',
                    'value' => (isset($option['content'])) ? $option['content'] : '' ,
                    'atts' =>  [
                      'placeholder' => 'Enter Page title',
                      'aria-describedby' => 'Enter Page title', 
                      'class' => 'form-control post_type_chack_slug',
                    ]
                  ], $error_msg); ?>

<?php echo text_field([
                    'name' => 'textdomain',
                    'title' => 'Page title',
                    'value' => (isset($option['textdomain'])) ? $option['textdomain'] : '' ,
                    'atts' =>  [
                      'placeholder' => 'Enter Page title',
                      'aria-describedby' => 'Enter Page title', 
                      'class' => 'form-control post_type_chack_slug',
                    ]
                  ], $error_msg); ?>

<?php echo heml_card_close(); ?>

 <?php echo Form::submit('Save', ['class' => 'btn bg-olive btn-flat pull-left']); ?>
 
	  </div>
	</div>
<?php echo Form::close(); ?>
    	<?php
    }


    public function option_validation($data){
    	return Validator::make($data, [
                'post_title'      => 'required|string|max:255|',
            ]
        );
    }

    public function option_update($data){
        $option_save = new options('genarel');
        $option_save->add_option('post_title', $data['post_title']);
        $option_save->add_option('content', $data['content']);
        $option_save->add_option('textdomain', $data['textdomain']);
        $option_save->option_update();
        return redirect()->back()->with('success_msg', 'Optuons Update Successful.');
    }
}
