@extends('layouts.userauth')

@section('auth_tab_title')
Reset Password
@endsection

@section('auth_title')
<a href="/"><b>Reset</b>Password</a>
@endsection
@section('auth_content')



    <p class="login-box-msg">Forgot password</p>
    
    @if(Session::get('pass_send_successfully'))
    <div class="alert alert-success" role="alert">
      <strong>!Success</strong> {{ Session::get('pass_send_successfully') }}
    </div>
    @endif

    {!! Form::open(['url' => route('password.request'), 'method' => 'POST']) !!}

      <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::email('email', old('email') , ['placeholder' => 'E-Mail Address', 'aria-describedby' => 'E-MailAddress', 'class' => 'form-control', 'id' => 'useremail']) !!}
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif 
      </div>

      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::password('password', [
                'placeholder' => 'Password',  
                'class' => 'form-control',  
                'id' => 'password'
              ]) !!}   
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif 
      </div>

      <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            {!! Form::password('password_confirmation', [
                'placeholder' => 'Confirm Password',  
                'class' => 'form-control',  
                'id' => 'password_confirmation'
              ]) !!}   
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif 
      </div>

  
      {!! Form::submit('Send Password Link', ['class' => 'btn btn-primary btn-block']) !!}          
    {!! Form::close() !!}

    <div class="social-auth-links text-center">
      <p>- OR -</p>
		<a href="{{ route('facebook_action') }}" class="btn btn-block btn-social btn-facebook">
			<i class="fa fa-facebook"></i> 
			Sign in using Facebook
		</a>
		<a href="{{ route('google_action') }}" class="btn btn-block btn-social btn-google">
			<i class="fa fa-google-plus"></i> 
			Sign in using Google+
		</a>
		<a href="{{ route('twitter_action') }}" class="btn btn-block btn-social btn-twitter">
			<i class="fa fa-twitter"></i> 
			Sign in using Twitter
		</a>
    </div>
    <!-- /.social-auth-links -->


    <a href="{{ route('login') }}">Login</a><br />
    <a href="{{ route('register') }}">Register an Account</a>

@endsection
