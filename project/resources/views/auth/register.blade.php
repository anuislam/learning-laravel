@extends('layouts.userauth')

@section('auth_tab_title')
Registration
@endsection

@section('auth_title')
Registration
@endsection
@section('auth_content')
      <div class="card-body">
        {!! Form::open(['url' => route('register'), 'method' => 'POST']) !!}
        
          <div class="form-group {{ $errors->has('fname') ? ' has-error' : '' }}">            
            {!! Form::label('fname', 'Frist Name') !!}
            {!! Form::text('fname', old('fname') , [
                'placeholder' => 'Frist Name', 
                'class' => 'form-control', 
                'required' => '', 
                'autofocus' => '', 
                'id' => 'fname'
                ]) !!}   
            @if ($errors->has('fname'))
                <span class="help-block">
                    <strong>{{ $errors->first('fname') }}</strong>
                </span>
            @endif         
          </div>
        
          <div class="form-group {{ $errors->has('lname') ? ' has-error' : '' }}">            
            {!! Form::label('lname', 'Last Name') !!}
            {!! Form::text('lname', old('lname') , [
                'placeholder' => 'Last Name',
                'class' => 'form-control',
                'required' => '', 
                'autofocus' => '', 
                'id' => 'lname'
                ]) !!}   
            @if ($errors->has('lname'))
                <span class="help-block">
                    <strong>{{ $errors->first('lname') }}</strong>
                </span>
            @endif         
          </div>


          <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">            
            {!! Form::label('useremail', 'Email address') !!}
            {!! Form::email('email', old('email') , [
                'placeholder' => 'Enter email', 
                'aria-describedby' => 'emailHelp', 
                'class' => 'form-control', 
                'required' => '', 
                'autofocus' => '',
                'id' => 'useremail'
            ]) !!}   
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif         
          </div>

          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}"> 
            {!! Form::label('userpassword', 'Password') !!}
            {!! Form::password('password', [
                'class' => 'form-control', 
                'id' => 'userpassword', 
                'required' => '', 
                'autofocus' => '',
                'placeholder' => 'Password'
            ]) !!}
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}"> 
            {!! Form::label('password_confirmation', 'Confirm Password') !!}
            {!! Form::password('password_confirmation', [
                'class' => 'form-control', 
                'id' => 'userpassword', 
                'required' => '', 
                'autofocus' => '',
                'placeholder' => 'Confirm Password'
            ]) !!}
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
          </div>


          {!! Form::submit('Register', ['class' => 'btn btn-primary btn-block']) !!}          
        {!! Form::close() !!}
        <div class="text-center">
          <a class="d-block small mt-3" href="{{ route('login') }}">Login</a>
        </div>
      </div>
@endsection
