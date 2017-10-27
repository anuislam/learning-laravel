@extends('layouts.dashboard')

@section('dashboard_tab_title')
Edith User
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

{{ heml_card_open('fa fa-user', 'Edith User') }}

            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    {{ Html::image(get_gravatar_custom_img($edith_user['email'], 200), $edith_user['fname'], array('class' => 'img-thumbnail')) }}
                  </div>
                </div>

                <!-- Start Form -->
            {!! Form::open(['url' => action('Admin\UsersController@update', ['id' => $edith_user['id']]), 'method' => 'PUT']) !!} 

                {{ text_field([
                    'name' => 'fname',
                    'title' => 'First Name',
                    'value' => @$edith_user['fname'],
                    'atts' =>  ['placeholder' => 'First Name', 'aria-describedby' => 'FirstName', 'class' => 'form-control']
                  ], $errors) }}

                {{ text_field([
                    'name' => 'lname',
                    'title' => 'Last Name',
                    'value' => @$edith_user['lname'],
                    'atts' =>  ['placeholder' => 'Last Name', 'aria-describedby' => 'LasttName', 'class' => 'form-control']
                  ], $errors) }}

                {{ email_field([
                    'name' => 'email',
                    'title' => 'Email Address',
                    'value' => @$edith_user['email'],
                    'atts' =>  ['placeholder' => 'Email Address', 'aria-describedby' => 'EmailAddress', 'class' => 'form-control']
                  ], $errors) }}

              @if($userpermission->user_can('edith_roll', $current_user['id']))

                {{ select_field([
                    'name' => 'roll',
                    'title' => 'User Roll',
                    'value' => @$edith_user['roll'],
                    'atts' =>  ['aria-describedby' => 'Userrool', 'class' => 'form-control'],
                    'items' =>   $userpermission->get_roll(),
                  ], $errors) }}

              @endif

                {{ textarea_field([
                    'name' => 'description',
                    'title' => 'Description',
                    'value' => @$edith_user['description'],
                    'atts' =>  ['placeholder' => 'Description', 'aria-describedby' => 'Description', 'class' => 'form-control']
                  ], $errors) }}

                {{ url_field([
                    'name' => 'website',
                    'title' => 'Website',
                    'value' => @$edith_user['website'],
                    'atts' =>  ['placeholder' => 'Website', 'aria-describedby' => 'Website', 'class' => 'form-control']
                  ], $errors) }}

                {{ url_field([
                    'name' => 'facebook',
                    'title' => 'Facebook Profile Url',
                    'value' => @$edith_user['facebook'],
                    'atts' =>  ['placeholder' => 'Facebook Profile Url', 'aria-describedby' => 'FacebookProfileUrl', 'class' => 'form-control']
                  ], $errors) }}

                {{ url_field([
                    'name' => 'google',
                    'title' => 'Google Profile Url',
                    'value' => @$edith_user['google'],
                    'atts' =>  ['placeholder' => 'Google Profile Url', 'aria-describedby' => 'GoogleProfileUrl', 'class' => 'form-control']
                  ], $errors) }}

                  {!! Form::hidden('user_id', $edith_user['id']) !!}  

                  {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!} 

              {!! Form::close() !!}
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close('Last Updated '.$edith_user['updated_at']) }}

      </div>
    </div>

@endsection