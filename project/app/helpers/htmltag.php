<?php

function text_field($data = array(), $errors){
  $data['name']      = (isset($data['name'])) ? $data['name'] : '' ;
  $data['title']     = (isset($data['title'])) ? $data['title'] : '' ;
  $data['value']     = (isset($data['value'])) ? $data['value'] : '' ;
  $data['atts']      = (isset($data['atts'])) ? $data['atts'] : [] ;  
  ?>

    <div class="form-group <?php echo $errors->has($data['name']) ? 'has-error' : '' ?>">
      <?php echo Form::label( $data['name'], $data['title'] ); ?>
      <?php echo Form::text(  $data['name'], $data['value'], $data['atts'] ); ?>
      <?php if ($errors->has($data['name'])) : ?>
        <span class="help-block">
            <strong><?php echo $errors->first($data['name'])  ?></strong>
        </span>
      <?php endif; ?>
    </div>

  <?php
}

function password_field($data = array(), $errors){
  $data['name']      = (isset($data['name'])) ? $data['name'] : '' ;
  $data['title']     = (isset($data['title'])) ? $data['title'] : '' ;
  $data['atts']      = (isset($data['atts'])) ? $data['atts'] : [] ;  
  ?>

    <div class="form-group <?php echo $errors->has($data['name']) ? 'has-error' : '' ?>">
      <?php echo Form::label( $data['name'], $data['title'] ); ?>
      <?php echo Form::password( $data['name'], $data['atts'] ); ?>
      <?php if ($errors->has($data['name'])) : ?>
        <span class="help-block">
            <strong><?php echo $errors->first($data['name'])  ?></strong>
        </span>
      <?php endif; ?>
    </div>

  <?php
}

function select_field($data = array(), $errors){
  $data['name']      = (isset($data['name'])) ? $data['name'] : '' ;
  $data['title']     = (isset($data['title'])) ? $data['title'] : '' ;
  $data['value']     = (isset($data['value'])) ? $data['value'] : '' ;
  $data['atts']      = (isset($data['atts'])) ? $data['atts'] : [] ;  
  $data['items']      = (isset($data['items'])) ? $data['items'] : [] ;  
  ?>

    <div class="form-group <?php echo $errors->has($data['name']) ? 'has-error' : '' ?>">
      <?php echo Form::label( $data['name'], $data['title'] ); ?>

      <?php echo Form::select($data['name'], $data['items'], $data['value'], $data['atts'] ); ?>
      <?php if ($errors->has($data['name'])) : ?>
        <span class="help-block">
            <strong><?php echo $errors->first($data['name'])  ?></strong>
        </span>
      <?php endif; ?>
    </div>

  <?php
}

function email_field($data = array(), $errors){
	$data['name'] 		 = (isset($data['name'])) ? $data['name'] : '' ;
	$data['title'] 		 = (isset($data['title'])) ? $data['title'] : '' ;
	$data['value'] 		 = (isset($data['value'])) ? $data['value'] : '' ;
	$data['atts'] 		 = (isset($data['atts'])) ? $data['atts'] : [] ;	
	?>

    <div class="form-group <?php echo $errors->has($data['name']) ? 'has-error' : '' ?>">
      <?php echo Form::label( $data['name'], $data['title'] ); ?>
      <?php echo Form::email(  $data['name'], $data['value'], $data['atts'] ); ?>
      <?php if ($errors->has($data['name'])) : ?>
        <span class="help-block">
            <strong><?php echo $errors->first($data['name'])  ?></strong>
        </span>
      <?php endif; ?>
    </div>

	<?php
}

function textarea_field($data = array(), $errors){
	$data['name'] 		 = (isset($data['name'])) ? $data['name'] : '' ;
	$data['title'] 		 = (isset($data['title'])) ? $data['title'] : '' ;
	$data['value'] 		 = (isset($data['value'])) ? $data['value'] : '' ;
	$data['atts'] 		 = (isset($data['atts'])) ? $data['atts'] : [] ;	
	?>

    <div class="form-group <?php echo $errors->has($data['name']) ? 'has-error' : '' ?>">
      <?php echo Form::label( $data['name'], $data['title'] ); ?>
      <?php echo Form::textarea(  $data['name'], $data['value'], $data['atts'] ); ?>
      <?php if ($errors->has($data['name'])) : ?>
        <span class="help-block">
            <strong><?php echo $errors->first($data['name'])  ?></strong>
        </span>
      <?php endif; ?>
    </div>

	<?php
}

function url_field($data = array(), $errors){
	$data['name'] 		 = (isset($data['name'])) ? $data['name'] : '' ;
	$data['title'] 		 = (isset($data['title'])) ? $data['title'] : '' ;
	$data['value'] 		 = (isset($data['value'])) ? $data['value'] : '' ;
	$data['atts'] 		 = (isset($data['atts'])) ? $data['atts'] : [] ;	
	?>

    <div class="form-group <?php echo $errors->has($data['name']) ? 'has-error' : '' ?>">
      <?php echo Form::label( $data['name'], $data['title'] ); ?>
      <?php echo Form::url(  $data['name'], $data['value'], $data['atts'] ); ?>
      <?php if ($errors->has($data['name'])) : ?>
        <span class="help-block">
            <strong><?php echo $errors->first($data['name'])  ?></strong>
        </span>
      <?php endif; ?>
    </div>

	<?php
}

function heml_card_open($icon = '', $title = ''){	
	?>
	<div class="card mb-3">
		<div class="card-header">
		<i class="<?php echo $icon; ?>"></i> <?php echo $title; ?>
		</div>
		<div class="card-body">
	<?php
}

function heml_card_close($title = ''){	
	?>

		</div>
      <div class="card-footer small text-muted">
        <?php echo $title; ?>
      </div>
	</div>
	<?php
}


function return_mb($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    if ($last == 'm') {
       $val = (int)str_replace('m', 'sdsd', $val);
       $val .= 'MB';
    }else if ($last == 'k') {
      $val = (int)str_replace('k', '', $val);
      $val .= 'KB';
    }else{
      $val = (int)str_replace('g', '', $val);
      $val .= 'GB';
    }
    return $val;
}

function media_uploader($data = array(), $errors){
  $data['name']      = (isset($data['name'])) ? $data['name'] : '' ;
  $data['title']     = (isset($data['title'])) ? $data['title'] : '' ;
  $data['value']     = (isset($data['value'])) ? $data['value'] : '' ;
  $data['value']     = ($data['value'] == '0') ? '' : $data['value'] ;
  $data['atts']      = (isset($data['atts'])) ? $data['atts'] : [] ;  
  $data['atts']['id']     = $data['name'];  
  $media = new App\mediaModel();
  $post = new App\post();
  ?>

    <div class="form-group <?php echo $errors->has($data['name']) ? 'has-error' : '' ?>">
      <?php echo Form::label( $data['name'], $data['title'], ['style' => 'width:100%;'] ); ?>
        <a href="javascript:void(0)"            
            <?php

              if (is_array($data['atts'])) {
                foreach ($data['atts'] as $key => $value) {
                  echo ''.$key.'="'.$value.'" ';
                }
              }

            ?>
            onclick="open_media_uploader(this)"
        >
          <?php echo $data['title']; ?>
        </a>


      <?php if ($errors->has($data['name'])) : ?>
        <span class="help-block">
            <strong><?php echo $errors->first($data['name'])  ?></strong>
        </span>
      <?php endif; ?>

          <div id="uploader_image_preview" <?php echo (empty($data['value']) === false) ? 'style="display:block;"' : '' ;  ?>>
      <?php
        if (empty($data['value']) === false) {
            $media_details = $media->get_media($data['value']);
            $file_type = $post->get_post_meta($data['value'], 'file_type');
            $preview_image = $media->get_image_src('media_preview', $data['value']);
            if (is_image($file_type) === true) {
              ?>
              <img src="<?php echo $preview_image[0]; ?>" class="rounded float-left img-thumbnail" alt="<?php echo $media_details->post_title; ?>">
              <?php
            }else{
            ?>
              <img src="<?php echo upload_dir_url('default/largefileicon.png'); ?>" class="rounded float-left img-thumbnail" alt="<?php echo $media_details->post_title; ?>">
            <?php
           }
        }
      ?>      

          </div>
      <?php echo Form::hidden( $data['name'], $data['value'], ['id' =>  $data['name'].'-1']); ?>

    </div>

  <?php
}
