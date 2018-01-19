<?php

function date_range_field($data = array(), $errors){
  $data['name']      = (isset($data['name'])) ? $data['name'] : '' ;
  $data['title']     = (isset($data['title'])) ? $data['title'] : '' ;
  $data['value']     = (isset($data['value'])) ? $data['value'] : '' ;
  $data['icon']       = (isset($data['icon'])) ? $data['icon'] : 'fa fa-calendar' ;
  $data['atts']      = (isset($data['atts'])) ? $data['atts'] : [] ;  
  ?>

    <div class="form-group <?php echo $errors->has($data['name']) ? 'has-error' : '' ?>">
      <?php echo Form::label( $data['name'], $data['title'], ['class' => 'control-label'] ); ?>
      <div class="input-group">
        <div class="input-group-addon">
          <i class="<?php echo $data['icon']; ?>"></i>
        </div>

        <?php echo Form::text(  $data['name'], $data['value'], $data['atts'] ); ?>
      </div>
      <?php if ($errors->has($data['name'])) : ?>
        <span class="help-block">
            <strong><?php echo $errors->first($data['name'])  ?></strong>
        </span>
      <?php endif; ?>
    </div>
  <?php
}

function text_field($data = array(), $errors){
  $data['name']      = (isset($data['name'])) ? $data['name'] : '' ;
  $data['title']     = (isset($data['title'])) ? $data['title'] : '' ;
  $data['value']     = (isset($data['value'])) ? $data['value'] : '' ;
  $data['atts']      = (isset($data['atts'])) ? $data['atts'] : [] ;  
  ?>


  <div class="form-group <?php echo $errors->has($data['name']) ? 'has-error' : '' ?>">
    <?php echo Form::label( $data['name'], $data['title'], ['class' => 'control-label'] ); ?>
    <?php echo Form::text(  $data['name'], $data['value'], $data['atts'] ); ?>
    <?php if ($errors->has($data['name'])) : ?>
    <span class="help-block">
        <strong><?php echo $errors->first($data['name'])  ?></strong>
    </span>
    <?php endif; ?>
  </div>

  <?php
}

function number_field($data = array(), $errors){
  $data['name']      = (isset($data['name'])) ? $data['name'] : '' ;
  $data['title']     = (isset($data['title'])) ? $data['title'] : '' ;
  $data['value']     = (isset($data['value'])) ? $data['value'] : '' ;
  $data['atts']      = (isset($data['atts'])) ? $data['atts'] : [] ;  
  ?>


  <div class="form-group <?php echo $errors->has($data['name']) ? 'has-error' : '' ?>">
    <?php echo Form::label( $data['name'], $data['title'], ['class' => 'control-label'] ); ?>
    <?php echo Form::number(  $data['name'], $data['value'], $data['atts'] ); ?>
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
    <?php echo Form::label( $data['name'], $data['title'], ['class' => 'control-label'] ); ?>
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
    <?php echo Form::label( $data['name'], $data['title'], ['class' => 'control-label'] ); ?>
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
    <?php 
    if (empty($data['title']) === false) {
      echo Form::label( $data['name'], $data['title'], ['class' => 'control-label'] );
    }
    ?>
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
    <?php echo Form::label( $data['name'], $data['title'], ['class' => 'control-label'] ); ?>
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

  <div class="box box-success">
    <div class="box-header with-border ">
      <h3 class="box-title"><i class="<?php echo $icon; ?>"></i> <?php echo $title; ?></h3>


    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
    </div>


    </div>
    <div class="box-body">


	<?php
}

function heml_card_close(){	
	?>
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
  $post = new App\BlogPost();
  ?>

    <div class="form-group <?php echo $errors->has($data['name']) ? 'has-error' : '' ?>">
      <?php echo Form::label( $data['name'], $data['title'], ['style' => 'width:100%;'] ); ?>
        <a href="javascript:void(0)"            
            <?php

              if (isset($data['atts'])) {
                if (is_array($data['atts'])) {
                  foreach ($data['atts'] as $key => $value) {
                    echo ''.$key.'="'.$value.'" ';
                  }
                }
              }

            ?>
            onclick="open_media_uploader(this)"
        >
          <?php echo $data['title']; ?>
        </a>
        <a href="javascript:void(0)" class="btn bg-maroon btn-flat" onclick="media_removetag(this)">Remove</a>

      <?php if ($errors->has($data['name'])) : ?>
        <span class="help-block">
            <strong><?php echo $errors->first($data['name'])  ?></strong>
        </span>
      <?php endif; ?>

          <div style="text-align: center;" class="uploader_image_preview" <?php echo (empty($data['value']) === false) ? 'style="display:block;"' : '' ;  ?>>
      <?php
        if (empty($data['value']) === false) {
            $media_details = $media->get_media($data['value']);
            if ($media_details) {
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
        }
      ?>      

          </div>
      <?php echo Form::hidden( $data['name'], $data['value'], ['id' =>  $data['name'].'-1']); ?>

    </div>

  <?php
}



function html_tab($content){
  ?>


          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

<?php
$a1 = 0;

if (is_array($content)) {
  foreach ($content as $tab_key => $tab_value) {
    ?>

      <li class="<?php echo ($a1 == 0) ? 'active' : '' ; ?>"><a href="#tab_<?php echo $tab_key; ?>" data-toggle="tab" ><?php echo $tab_value['tab_title'] ?></a></li>

    <?php
    $a1++;
  }
}

?>
            </ul>
            <div class="tab-content">


<?php

$a2 = 0;

if (is_array($content)) {
  foreach ($content as $tab_key => $tab_value) {
    ?>


    <div class="tab-pane <?php echo ($a2 == 0) ? 'active' : '' ; ?>" id="tab_<?php echo $tab_key; ?>">
      <?php echo $tab_value['tab_content'] ?>
    </div>

    <?php
    $a2++;
  }
}


?>            
            </div>
            <!-- /.tab-content -->
          </div>
  <?php
}



function post_type_slug_checker($ajax_url, $value = '', $atts = array()){
?>
  <div class="form-group" 
    
    data-chack-url="<?php echo $ajax_url; ?>"
    data-chack-value="<?php echo (empty($value) === false) ? $value : '' ?>"
            <?php

              if (isset($atts['atts'])) {
                if (is_array($atts['atts'])) {
                  foreach ($atts['atts'] as $attskey => $attsvalue) {
                    echo ''.$attskey.'="'.$attsvalue.'" ';
                  }
                }
              }

            ?>
    >
    <label for="post_slug" class="control-label"><?php echo @$atts['title'] ?></label>
    <div class="input-group input-group-sm">    
      <?php echo Form::hidden(
        'post_slug', (empty($value) === false) ? $value : ''  ); ?>
      <span class="form-control"><?php echo (empty($value) === false) ? $value : '' ?></span>
      <span class="input-group-btn">
        <button type="button" class="btn bg-olive" 

        onclick="open_modal_chack_slug(this)"
        data-title="<?php echo @$atts['title'] ?>"
        cancel_text="Cancel"
        submit_text="Change"
        
        >Edit</button>
      </span>
    </div>
  </div>
<?php


}



function submib_button($data, $error = ''){
  echo Form::submit($data['title'], $data['attr']);
}



