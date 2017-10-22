@extends('layouts.userauth')

@section('auth_tab_title')
Reset Password
@endsection

@section('auth_title')
Reset Password
@endsection
@section('auth_content')
      <div class="card-body">

        {!! Form::open(['url' => route('password.request'), 'method' => 'POST']) !!}

          <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">            
            {!! Form::label('useremail', 'E-Mail Address') !!}
            {!! Form::email('email', null , [
                'placeholder' => 'Enter email',  
                'class' => 'form-control', 
                'id' => 'useremail'
              ]) !!}   
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif         
          </div>

          <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">            
            {!! Form::label('password', 'Password') !!}
            {!! Form::password('password', [
                'placeholder' => 'Password',  
                'class' => 'form-control',  
                'id' => 'password'
              ]) !!}   
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif         
          </div>

          <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">            
            {!! Form::label('password_confirmation', 'Confirm Password') !!}
            {!! Form::password('password_confirmation', [
                'placeholder' => 'Confirm Password',  
                'class' => 'form-control',  
                'id' => 'password_confirmation'
              ]) !!}   
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif         
          </div>

          {!! Form::submit('Send Password Link', ['class' => 'btn btn-primary btn-block']) !!}          
        {!! Form::close() !!}
      </div>
@endsection
