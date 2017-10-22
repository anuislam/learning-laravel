@extends('layouts.userauth')

@section('auth_tab_title')
Login
@endsection

@section('auth_title')
Login
@endsection
@section('auth_content')
      <div class="card-body">
        {!! Form::open(['url' => route('login'), 'method' => 'POST']) !!}
        
          <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">            
            {!! Form::label('useremail', 'Email address') !!}
            {!! Form::email('email', old('email') , ['placeholder' => 'Enter email', 'aria-describedby' => 'emailHelp', 'class' => 'form-control', 'id' => 'useremail']) !!}   
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif         
          </div>
          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}"> 
            {!! Form::label('userpassword', 'Password') !!}
            {!! Form::password('password', ['class' => 'form-control', 'id' => 'userpassword', 'placeholder' => 'Password']) !!}
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                {!! Form::checkbox('remember', 'yes', false, ['class' => 'form-check-input']) !!} Remember Password</label>
            </div>
          </div>
          {!! Form::submit('Login', ['class' => 'btn btn-primary btn-block']) !!}          
        {!! Form::close() !!}
        <div class="text-center">
          <a class="d-block small mt-3" href="{{ route('register') }}">Register an Account</a>
          <a class="d-block small" href="{{ route('password.request') }}">Forgot Password?</a>
        </div>
      </div>
@endsection
