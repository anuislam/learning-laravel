@extends('layouts.dashboard')

@section('dashboard_tab_title')
Add New user
@endsection


@section('dashboard_content')
    <!-- Breadcrumbs-->
    @include('admin.inc.breadcrumb')

        @if(Session::get('error_msg'))
        <div class="alert alert-success" role="alert">
          <strong>!Success</strong> {{ Session::get('error_msg') }}
        </div>
        @endif
    <div class="row">
      <div class="col-md-8">

{{ heml_card_open('fa fa-user', 'Edith User') }}

            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->
            {!! Form::open(['url' => route('user.create'), 'method' => 'POST']) !!} 

                {{ text_field([
                    'name' => 'fname',
                    'title' => 'First Name',
                    'value' => old('fname'),
                    'atts' =>  ['placeholder' => 'First Name', 'aria-describedby' => 'FirstName', 'class' => 'form-control']
                  ], $errors) }}

                {{ text_field([
                    'name' => 'lname',
                    'title' => 'Last Name',
                    'value' => old('lname'),
                    'atts' =>  ['placeholder' => 'Last Name', 'aria-describedby' => 'LasttName', 'class' => 'form-control']
                  ], $errors) }}

                {{ email_field([
                    'name' => 'email',
                    'title' => 'Email Address',
                    'value' => old('email'),
                    'atts' =>  ['placeholder' => 'Email Address', 'aria-describedby' => 'EmailAddress', 'class' => 'form-control']
                  ], $errors) }}

                {{ textarea_field([
                    'name' => 'description',
                    'title' => 'Description',
                    'value' => old('description'),
                    'atts' =>  ['placeholder' => 'Description', 'aria-describedby' => 'Description', 'class' => 'form-control']
                  ], $errors) }}

                {{ url_field([
                    'name' => 'website',
                    'title' => 'Website',
                    'value' => old('website'),
                    'atts' =>  ['placeholder' => 'Website', 'aria-describedby' => 'Website', 'class' => 'form-control']
                  ], $errors) }}

                {{ url_field([
                    'name' => 'facebook',
                    'title' => 'Facebook Profile Url',
                    'value' => old('facebook'),
                    'atts' =>  ['placeholder' => 'Facebook Profile Url', 'aria-describedby' => 'FacebookProfileUrl', 'class' => 'form-control']
                  ], $errors) }}

                {{ url_field([
                    'name' => 'google',
                    'title' => 'Google Profile Url',
                    'value' => old('google'),
                    'atts' =>  ['placeholder' => 'Google Profile Url', 'aria-describedby' => 'GoogleProfileUrl', 'class' => 'form-control']
                  ], $errors) }} 

                  {!! Form::submit('Add New User', ['class' => 'btn btn-primary']) !!} 

              {!! Form::close() !!}
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close('Add New User.') }}

      </div>
    </div>

@endsection