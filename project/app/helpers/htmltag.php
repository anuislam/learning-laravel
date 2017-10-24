<?php


function text_field($data = array(), $errors){
	$data['name'] 		 = (isset($data['name'])) ? $data['name'] : '' ;
	$data['title'] 		 = (isset($data['title'])) ? $data['title'] : '' ;
	$data['value'] 		 = (isset($data['value'])) ? $data['value'] : '' ;
	$data['atts'] 		 = (isset($data['atts'])) ? $data['atts'] : [] ;	
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
