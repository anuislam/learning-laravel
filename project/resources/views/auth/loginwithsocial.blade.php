@extends('layouts.userauth')

@section('auth_tab_title')
Confirm Registration
@endsection

@section('auth_title')
<a href="{{ url('/') }}"><b>CONFIRM </b>REGISTRATION</a>
@endsection


@section('auth_content')


        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
                <h3 class="widget-user-username">{{ (empty($user['fname']) === false) ? $user['fname'] : '' }}</h3>
            </div>
            <div class="widget-user-image">
              @if(empty($user['image']) === false)
              {{ Html::image($user['image'], 'User Avatar', array('class' => 'img-circle', 'style' => 'height: 90px;width: 90px;')) }}
              }
              @endif
            </div>
            <div class="box-footer">
              <div class="row">                
                <div style="display:none;"></div>        
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
    

    {!! Form::open(['url' => route('confirm_registration'), 'method' => 'POST']) !!}
      {!! Form::hidden('profile_image', (empty($user['image']) === false) ? $user['image'] : old('profile_image')) !!}
      <div class="form-group has-feedback {{ $errors->has('fname') ? ' has-error' : '' }}">

        {!! Form::text('fname', (empty($user['fname']) === false) ? $user['fname'] : old('fname') , [
            'placeholder' => 'Frist Name', 
            'class' => 'form-control', 
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
            {!! Form::text('lname', (empty($user['lname']) === false) ? $user['lname'] : old('lname') , [
                'placeholder' => 'Last Name',
                'class' => 'form-control',
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
            {!! Form::email('email', (empty($user['email']) === false) ? $user['email'] : old('email') , [
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
        <!-- /.col -->
        <div class="col-sm-12">
          {!! Form::submit('Registration', ['class' => 'btn btn-block btn-primary btn-block btn-flat']) !!}
        </div>
        <!-- /.col -->
      </div>

    {!! Form::close() !!}


@endsection
