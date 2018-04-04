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
                    'name' => 'site_title',
                    'title' => 'Site title',
                    'value' => (isset($option['site_title'])) ? $option['site_title'] : '' ,
                    'atts' =>  [
                      'placeholder' => 'Enter Site title',
                      'aria-describedby' => 'Enter Site title', 
                      'class' => 'form-control post_type_chack_slug',
                    ]
                  ], $error_msg); ?>

<?php echo text_field([
                    'name' => 'site_desc',
                    'title' => 'Site Description',
                    'value' => (isset($option['site_desc'])) ? $option['site_desc'] : '' ,
                    'atts' =>  [
                      'placeholder' => 'Enter Site Description',
                      'aria-describedby' => 'Enter Site Description', 
                      'class' => 'form-control post_type_chack_slug',
                    ]
                  ], $error_msg); ?>

<?php echo text_field([
                    'name' => 'keywords',
                    'title' => 'Keywords',
                    'value' => (isset($option['keywords'])) ? $option['keywords'] : '' ,
                    'atts' =>  [
                      'placeholder' => 'Keywords',
                      'aria-describedby' => 'Keywords', 
                      'class' => 'form-control post_type_chack_slug',
                    ]
                  ], $error_msg); ?>

<?php echo text_field([
                    'name' => 'site_author',
                    'title' => 'Keywords',
                    'value' => (isset($option['site_author'])) ? $option['site_author'] : '' ,
                    'atts' =>  [
                      'placeholder' => 'Site Author',
                      'aria-describedby' => 'Site Author', 
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
                'site_title'        => 'string|max:200',
                'site_desc'         => 'string|max:500',
                'keywords'          => 'string',
                'site_author'       => 'string',
            ]
        );
    }

    public function option_update($data){
        $option_save = new options('genarel');
        $option_save->add_option('site_title', sanitize_text($data['site_title']));
        $option_save->add_option('site_desc', sanitize_text($data['site_desc']));
        $option_save->add_option('keywords', sanitize_text($data['keywords']));
        $option_save->add_option('site_author', sanitize_text($data['site_author']));
        $option_save->option_update();
        return redirect()->back()->with('success_msg', 'Optuons Update Successful.');
    }
}
