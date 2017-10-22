@extends('layouts.userauth')

@section('auth_tab_title')
Reset Password
@endsection

@section('auth_title')
Reset Password
@endsection
@section('auth_content')
      <div class="card-body">

        @if(Session::get('pass_send_successfully'))
        <div class="alert alert-success" role="alert">
          <strong>!Success</strong> {{ Session::get('pass_send_successfully') }}
        </div>
        @endif
        
        {!! Form::open(['url' => route('password.email'), 'method' => 'POST']) !!}

          <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">            
            {!! Form::label('useremail', 'E-Mail Address') !!}
            {!! Form::email('email', old('email') , [
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
          {!! Form::submit('Send Password Link', ['class' => 'btn btn-primary btn-block']) !!}          
        {!! Form::close() !!}
        <div class="text-center">
          <a class="d-block small mt-3" href="{{ route('login') }}">Login</a>
          <a class="d-block small" href="{{ route('register') }}">Register an Account</a>
        </div>
      </div>
@endsection
