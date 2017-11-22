@extends('layouts.userauth')

@section('auth_tab_title')
Registration
@endsection

@section('auth_title')
<a href="/"><b>Registration</b>LTE</a>
@endsection
@section('auth_content')

    <p class="login-box-msg">Register a new membership</p>
    {!! Form::open(['url' => route('register'), 'method' => 'POST']) !!}




      <div class="form-group has-feedback {{ $errors->has('fname') ? ' has-error' : '' }}">

        {!! Form::text('fname', old('fname') , [
            'placeholder' => 'Frist Name', 
            'class' => 'form-control', 
            'required' => '', 
            'autofocus' => '', 
            'id' => 'fname'
            ]) !!}   

        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        @if ($errors->has('fname'))
            <span class="help-block">
                <strong>{{ $errors->first('fname') }}</strong>
            </span>
        @endif

      </div>

      <div class="form-group has-feedback {{ $errors->has('lname') ? ' has-error' : '' }}">
            {!! Form::text('lname', old('lname') , [
                'placeholder' => 'Last Name',
                'class' => 'form-control',
                'required' => '', 
                'autofocus' => '', 
                'id' => 'lname'
                ]) !!}   

        <span class="glyphicon glyphicon-user form-control-feedback"></span>
            @if ($errors->has('lname'))
                <span class="help-block">
                    <strong>{{ $errors->first('lname') }}</strong>
                </span>
            @endif 
      </div>

      <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::email('email', old('email') , [
                'placeholder' => 'Enter email', 
                'aria-describedby' => 'emailHelp', 
                'class' => 'form-control', 
                'required' => '', 
                'autofocus' => '',
                'id' => 'useremail'
            ]) !!}  

            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif 
      </div>

      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::password('password', [
                'class' => 'form-control', 
                'id' => 'userpassword', 
                'required' => '', 
                'autofocus' => '',
                'placeholder' => 'Password'
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
                'class' => 'form-control', 
                'id' => 'userpassword', 
                'required' => '', 
                'autofocus' => '',
                'placeholder' => 'Confirm Password'
            ]) !!}

        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif 
      </div>


      <div class="row">

        <div class="col-xs-8 {{ $errors->has('agreement') ? ' has-error' : '' }}">
          <div class="checkbox icheck">
            <label>
              {!! Form::checkbox('agreement', 'yes', false) !!} I agree to the <a href="#">terms
            </label>
          </div>

        @if ($errors->has('agreement'))
            <span class="help-block">
                <strong>{{ $errors->first('agreement') }}</strong>
            </span>
        @endif

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

    <a href="{{ route('login') }}" class="text-center">Login</a>


@endsection
