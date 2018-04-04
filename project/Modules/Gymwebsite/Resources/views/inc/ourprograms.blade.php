<div id="fh5co-programs-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="heading-section text-center animate-box">
					<h2>{{$home_settings['program_sec_titile']}}</h2>
					<p>{{$home_settings['program_sec_desc']}}</p>
				</div>
			</div>
		</div>
		<div class="row text-center">

			@foreach($programs as $key => $value)

			<div class="col-md-4 col-sm-6">
				<div class="program animate-box">
					<img src="{!! upload_dir_url($media->get_media($meta_data->get_post_meta($value->id, 'program_icon'))->post_content) !!}" alt="Cycling">
					<h3>{{$value->post_title}}</h3>
					<p>{{$value->post_content}}</p>
					<span><a href="javascript:void(0)" post-title="{{$value->post_title}}" class="btn btn-default" onclick="openJoinNowModal(this)" >Join Now</a></span>
				</div>
			</div>

			@endforeach;
		</div>
	</div>
</div>

<!-- Modal -->
<div id="joinnowmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">		
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">

<div class="print-error-msg" style="display: block;">
		<ul style="text-decoration: none;list-style: none;padding: 0;">
		</ul>
	</div>
		<div class="form-group">
			{!! Form::label( 'joinemail', 'Email address') !!}
			{!! Form::email( 'joinemail' , '', ['class' => 'form-control','placeholder' => 'Email address'] ) !!}
		</div>
		<div class="form-group">
			{!! Form::label( 'joinmobile', 'Mobile') !!}
			{!! Form::number( 'joinmobile' , '', ['class' => 'form-control','placeholder' => 'Mobile'] ) !!}		
		</div>		
		<div class="form-group">			
			{!! Form::label( 'joinmessage', 'Message') !!}
			{!! Form::textarea( 'joinmessage' , '', ['class' => 'form-control','placeholder' => 'Message'] ) !!}		
		</div>					
      </div>
      <div class="modal-footer">

      	{!! Form::submit('Cancel', [
	      	'class' => 'btn btn-default pull-left',
	      	'data-dismiss' => 'modal',
	      	]) !!}
      	{!! Form::submit('Send', [
	      	'class' => 'btn btn-default',
	      	'id' => 'joinsendmessage',
	      	]) !!}
      </div>
    </div>

  </div>
</div>