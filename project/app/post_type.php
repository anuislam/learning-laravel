<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;
class post_type extends Model{
    
	public function post_content_output($error_msg = ''){
		Form::open(['url' => route('stor-user'), 'method' => 'POST'])
?>


    <div class="row">
      <div class="col-md-8">

<?php echo heml_card_open('fa fa-pencil', 'Post title'); ?>

<?php echo text_field([
                    'name' => 'post_title',
                    'title' => 'Post title',
                    'value' => old('post_title'),
                    'atts' =>  [
                    	'placeholder' => 'Enter post title',
                    	'aria-describedby' => 'Enter post title', 
                    	'class' => 'form-control',
                    ]
                  ], $error_msg);
?>


	<div class="form-group">
		<label for="post_title" class="control-label">Post slug</label>
		<div class="input-group input-group-sm">    
			<span class="form-control">sdsdsdsdsdsd</span>
			<span class="input-group-btn">
				<button type="button" class="btn bg-olive">Edit</button>
			</span>
		</div>
	</div>



<?php echo heml_card_close(); ?>

<?php echo heml_card_open('fa fa-pencil', 'Post Content'); ?>

	<?php echo	textarea_field([
                    'name' => 'post_content',
                    'value' => old('description'),
                    'atts' =>  [
                    	'placeholder' => 'Description', 
                    	'aria-describedby' => 'Description', 
                    	'class' => 'tainy_mce'
                    	]
                  ], $error_msg);
    ?>	

<?php echo heml_card_close(); ?>

<?php echo heml_card_open('fa fa-pencil', 'Post Meta'); ?>
   	<?php echo  select_field([
        'name' => 'Multiple',
        'title' => 'User Roll',
        'value' => ['California','Alabama','Alaska'],
        'atts' =>  [
        		'aria-describedby' => 'Userrool', 
        		'class' => 'form-control select2', 
        		'style' => 'width: 100%;',
        		'multiple' => 'multiple',
        	],
        'items' =>  [
        	'Alabama' => 'Alabama',
        	'Alaska' => 'Alaska',
        	'California' => 'California',
        ],
      ], $error_msg); ?>
  <?php echo heml_card_close(); ?>

      </div>


		<div class="col-md-4">
			<?php echo heml_card_open('fa fa-pencil', 'Post publish'); ?>
               	<?php echo  select_field([
                    'name' => 'post_status',
                    'title' => 'Post status',
                    'value' => 'publish',
                    'atts' =>  [
                    		'aria-describedby' => 'Userrool', 
                    		'class' => 'form-control select2', 
                    		'style' => 'width: 100%;',
                    	],
                    'items' =>  [
                    	'publish' => 'Publish',
                    	'pending' => 'Pending',
                    	'trush' => 'Trush',
                    ],
                  ], $error_msg); ?>

                  <?php echo Form::submit('Publish', ['class' => 'btn bg-olive btn-flat pull-right']); ?>

              <?php echo heml_card_close(); ?>

			<?php echo heml_card_open('fa fa-pencil', 'Post tag'); ?>
               	<?php echo  select_field([
                    'name' => 'Multiple',
                    'title' => 'User Roll',
                    'value' => ['California','Alabama','Alaska'],
                    'atts' =>  [
                    		'aria-describedby' => 'Userrool', 
                    		'class' => 'form-control select2', 
                    		'style' => 'width: 100%;',
                    		'multiple' => 'multiple',
                    	],
                    'items' =>  [
                    	'Alabama' => 'Alabama',
                    	'Alaska' => 'Alaska',
                    	'California' => 'California',
                    ],
                  ], $error_msg); ?>
              <?php echo heml_card_close(); ?>

			<?php echo heml_card_open('fa fa-pencil', 'Post category'); ?>
               	<?php echo  select_field([
                    'name' => 'Multiple',
                    'title' => 'User Roll',
                    'value' => ['California','Alabama','Alaska'],
                    'atts' =>  [
                    		'aria-describedby' => 'Userrool', 
                    		'class' => 'form-control select2', 
                    		'style' => 'width: 100%;',
                    		'multiple' => 'multiple',
                    	],
                    'items' =>  [
                    	'Alabama' => 'Alabama',
                    	'Alaska' => 'Alaska',
                    	'California' => 'California',
                    ],
                  ], $error_msg); ?>
              <?php echo heml_card_close(); ?>

			<?php echo heml_card_open('fa fa-pencil', 'Post image'); ?>
               	<?php echo  media_uploader([
				'name' => 'post_image',
				'title' => 'Upload Image',
				'value' => old('post_image'),
				'atts' =>  [
					'class' 		 => 'btn bg-purple btn-flat', 
					'cancel_text' 	 => 'Cancel post image',
					'submit_text' 	 => 'Select post image',
					 ]
			], $error_msg); ?>
              <?php echo heml_card_close(); ?>
		</div>

    </div>
<?php echo Form::close();
	}	

}
