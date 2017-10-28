@extends('layouts.dashboard')

@section('dashboard_tab_title')
Change Password
@endsection


@section('dashboard_content')
    <!-- Breadcrumbs-->
    @include('admin.inc.breadcrumb')


        @if(Session::get('error_msg'))
        <div class="alert alert-danger" role="alert">
          <strong>!Error</strong> {{ Session::get('error_msg') }}
        </div>
        @endif

        @if(Session::get('success_msg'))
        <div class="alert alert-success" role="alert">
          <strong>!Success</strong> {{ Session::get('success_msg') }}
        </div>
        @endif
        
    <div class="row">
      <div class="col-md-8">

{{ heml_card_open('fa fa-user', 'Change Password') }}

            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->
            {!! Form::open(['url' => route('update-change-password'), 'method' => 'POST']) !!} 

                {{ password_field([
                    'name' => 'current_password',
                    'title' => 'Current Password',
                    'atts' =>  ['placeholder' => 'Current Password', 'aria-describedby' => 'CurrentPassword', 'class' => 'form-control']
                  ], $errors) }}

                {{ password_field([
                    'name' => 'password',
                    'title' => 'Password',
                    'atts' =>  ['placeholder' => 'Password', 'aria-describedby' => 'Password', 'class' => 'form-control']
                  ], $errors) }}

                {{ password_field([
                    'name' => 'password_confirmation',
                    'title' => 'Confirm Password',
                    'atts' =>  ['placeholder' => 'Confirm Password', 'aria-describedby' => 'confirm_password', 'class' => 'form-control']
                  ], $errors) }}

                {!! Form::submit('Add New User', ['class' => 'btn btn-primary']) !!} 

            {!! Form::close() !!}
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close('Change Password.') }}

      </div>
    </div>

@endsection