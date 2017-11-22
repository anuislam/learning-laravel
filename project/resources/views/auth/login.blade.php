@extends('layouts.userauth')

@section('auth_tab_title')
Login
@endsection

@section('auth_title')
<a href="/"><b>Login</b>LTE</a>
@endsection
@section('auth_content')

    <p class="login-box-msg">Sign in to start your session</p>
    {!! Form::open(['url' => route('login'), 'method' => 'POST']) !!}

      <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::email('email', old('email') , ['placeholder' => 'Enter email', 'aria-describedby' => 'emailHelp', 'class' => 'form-control', 'id' => 'useremail']) !!}
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif 
      </div>

      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        {!! Form::password('password', ['class' => 'form-control', 'id' => 'userpassword', 'placeholder' => 'Password']) !!}
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif
      </div>


      <div class="row">

        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              {!! Form::checkbox('remember', 'yes', false) !!} Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          {!! Form::submit('Sign In', ['class' => 'btn btn-primary btn-block btn-flat']) !!}
        </div>
        <!-- /.col -->
      </div>

    {!! Form::close() !!}

    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
    <!-- /.social-auth-links -->

    <a href="{{ route('password.request') }}">I forgot my password</a><br>
    <a href="{{ route('register') }}" >Register a new membership</a>


@endsection
