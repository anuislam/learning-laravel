@extends('layouts.dashboard')

@section('dashboard_tab_title')
Admin Dashboard
@endsection


@section('dashboard_content')
    <!-- Breadcrumbs-->
    @include('admin.inc.breadcrumb')


    <div class="row">
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-header">
              <i class="fa fa-user"></i> Your Profile
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <img src="{{ get_gravatar_custom_img($current_user['email'], 200) }}" alt="{{ $current_user['fname'] }} {{ $current_user['lname'] }}" class="img-thumbnail">
                  </div>
                </div>
                <div class="row mb-3 mt-2">                  
                  <div class="col-md-6">
                    <a href="https://www.gravatar.com/" target="_blank" class="btn btn-secondary d-inline-block"> Change Image</a>
                    <a href="https://www.gravatar.com/" class="btn btn-secondary d-inline-block">Change password</a>
                  </div>
                </div>

                <!-- Start Form -->
                {!! Form::open(['url' => route('user.store'), 'method' => 'POST']) !!}              
                <div class="form-group">
                  {!! Form::label('fname', 'First Name') !!}
                  {!! Form::text('fname', $current_user['fname'] , ['placeholder' => 'First Name', 'aria-describedby' => 'FirstName', 'class' => 'form-control', 'id' => 'fname']) !!} 
                  @if ($errors->has('fname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('fname') }}</strong>
                    </span>
                  @endif     
                </div>

                <div class="form-group">
                  {!! Form::label('lname', 'Last Name') !!}
                  {!! Form::text('lname', $current_user['lname'] , ['placeholder' => 'Last Name', 'aria-describedby' => 'LasttName', 'class' => 'form-control', 'id' => 'lname']) !!}
                  @if ($errors->has('lname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('lname') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  {!! Form::label('email', 'Email Address') !!}
                  {!! Form::email('email', $current_user['email'] , ['placeholder' => 'Email Address', 'aria-describedby' => 'EmailAddress', 'class' => 'form-control', 'id' => 'email']) !!}
                  @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>


                <div class="form-group">
                  {!! Form::label('description', 'Description') !!}
                  {!! Form::textarea('description', $current_user['description'] , ['placeholder' => 'Description', 'aria-describedby' => 'Description', 'class' => 'form-control', 'id' => 'description']) !!}
                   @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  {!! Form::label('website', 'Website') !!}
                  {!! Form::url('website', $current_user['website'] , ['placeholder' => 'Website', 'aria-describedby' => 'Website', 'class' => 'form-control', 'id' => 'website']) !!}
                   @if ($errors->has('website'))
                    <span class="help-block">
                        <strong>{{ $errors->first('website') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  {!! Form::label('facebook', 'Facebook Profile Url') !!}
                  {!! Form::url('facebook', $current_user['facebook'] , ['placeholder' => 'Facebook Profile Url', 'aria-describedby' => 'FacebookProfileUrl', 'class' => 'form-control', 'id' => 'facebook']) !!}
                  @if ($errors->has('facebook'))
                    <span class="help-block">
                        <strong>{{ $errors->first('facebook') }}</strong>
                    </span>
                  @endif
                </div>

                {!! Form::hidden('user_id', $current_user['id']) !!}  
                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}  
              {!! Form::close() !!}
              <!-- End Form -->

              </div>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Last Updated yesterday at 11:59 PM
          </div>
        </div>
      </div>
    </div>

@endsection