@php
$footer = get_option('footer_settings');
$footer_addr_data = (empty($footer['footer_addr']) === false) ? @unserialize($footer['footer_addr']) : '' ;
$social_link = (empty($footer['social_link']) === false) ? @unserialize($footer['social_link']) : '' ;
@endphp

<footer>
	<div id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-4 animate-box">
					<h3 class="section-title">{{ $footer['aboute_us'] }}</h3>
					<p>{{ $footer['aboute_us_desc'] }}</p>
				</div>  

				<div class="col-md-4 animate-box">
					<h3 class="section-title">{{ @$footer['footer_addr_title'] }}</h3>
					<ul class="contact-info">
						@if (empty($footer_addr_data) === false)
							@foreach ($footer_addr_data as $footerkey => $footervalue)
							<li><i class="{{$footervalue['icon']}}"></i>{{$footervalue['addr']}}</li>
							@endforeach
						@endif 
					</ul>
				</div>
				<div class="col-md-4 animate-box">
					<h3 class="section-title">{{ @$footer['footer_contact_title'] }}</h3>
					{{Form::open(['url' =>  route('send_mail'), 'method' => 'POST', 'class' => 'contact-form'])}}
						<div class="form-group  {{ $errors->has('name') ? 'has-error' : '' }}">				
							{{Form::label( 'name', 'Name', ['class' => 'sr-only'])}}
								{{ Form::text(  'name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name'] ) }}
							@if ($errors->has('name'))
								<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
								</span>
							@endif
						</div>
						<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">				
							{{Form::label( 'email', 'Email', ['class' => 'sr-only'])}}
							{{ Form::email(  'email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email'] ) }}
							@if ($errors->has('email'))
								<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
						<div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
							{{Form::label( 'message', 'Message', ['class' => 'sr-only'])}}
							{{Form::textarea(  'message', old('message'), ['class' => 'form-control', 'placeholder' => 'Message', 'rows' => '7'] )}}
							@if ($errors->has('message'))
								<span class="help-block">
								<strong>{{ $errors->first('message') }}</strong>
								</span>
							@endif
						</div>
						<div class="form-group">
							{{ Form::submit('Send Message', [
							'class' => 'btn btn-send-message btn-md',
							'id' => 'btn-submit',
							]) }}
						</div>
				        @if(Session::get('send_mail'))
							<div class="row">
								<div class="col-md-12">
									<div class="alert alert-success alert-dismissible">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										{{ Session::get('send_mail') }}
									</div>
								</div>
							</div>
				        @endif

				        @if(Session::get('error_send_mail'))
					        <div class="row">
					        	<div class="col-md-12">
							        <div class="alert alert-danger alert-dismissible">
							          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							          {{ Session::get('error_send_mail') }}
							        </div>
						        </div>
					        </div>
					    @endif
					{{Form::close()}}
				</div>
			</div>
			<div class="row copy-right">
				<div class="col-md-6 col-md-offset-3 text-center">
					<p class="fh5co-social-icons">
						@if (empty($social_link) === false)
							@foreach ($social_link as $socialkey => $socialvalue)
							<a href="{{$socialvalue['url']}}"><i class="{{$socialvalue['icon']}}"></i></a>
							@endforeach
						@endif 
					</p>
					<p>{{ $footer['footer_text'] }}</p>
				</div>
			</div>
		</div>
	</div>
</footer>