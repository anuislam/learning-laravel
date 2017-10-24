@extends('layouts.dashboard')

@section('dashboard_tab_title')
Admin Dashboard
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

{{ heml_card_open('fa fa-user', 'Your Profile') }}

            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    {{ Html::image(get_gravatar_custom_img($current_user['email'], 200), $current_user['fname'], array('class' => 'img-thumbnail')) }}
                  </div>
                </div>
                <div class="row mb-3 mt-2">                  
                  <div class="col-md-6">
                    {{ HTML::link('https://www.gravatar.com/', 'Change Image', array(
                    'target' => '_blank',
                    'class' => 'btn btn-secondary d-inline-block',
                    ))}}
                    {{ HTML::link('https://www.gravatar.com/', 'Change password', array(
                    'class' => 'btn btn-secondary d-inline-block',
                    ))}}
                  </div>
                </div>

                <!-- Start Form -->
            {!! Form::open(['url' => route('user.store'), 'method' => 'POST']) !!} 

                {{ text_field([
                    'name' => 'fname',
                    'title' => 'First Name',
                    'value' => $current_user['fname'],
                    'atts' =>  ['placeholder' => 'First Name', 'aria-describedby' => 'FirstName', 'class' => 'form-control']
                  ], $errors) }}

                {{ text_field([
                    'name' => 'lname',
                    'title' => 'Last Name',
                    'value' => $current_user['lname'],
                    'atts' =>  ['placeholder' => 'Last Name', 'aria-describedby' => 'LasttName', 'class' => 'form-control']
                  ], $errors) }}

                {{ email_field([
                    'name' => 'email',
                    'title' => 'Email Address',
                    'value' => $current_user['email'],
                    'atts' =>  ['placeholder' => 'Email Address', 'aria-describedby' => 'EmailAddress', 'class' => 'form-control']
                  ], $errors) }}

                {{ textarea_field([
                    'name' => 'description',
                    'title' => 'Description',
                    'value' => $current_user['description'],
                    'atts' =>  ['placeholder' => 'Description', 'aria-describedby' => 'Description', 'class' => 'form-control']
                  ], $errors) }}

                {{ url_field([
                    'name' => 'website',
                    'title' => 'Website',
                    'value' => $current_user['website'],
                    'atts' =>  ['placeholder' => 'Website', 'aria-describedby' => 'Website', 'class' => 'form-control']
                  ], $errors) }}

                {{ url_field([
                    'name' => 'facebook',
                    'title' => 'Facebook Profile Url',
                    'value' => $current_user['facebook'],
                    'atts' =>  ['placeholder' => 'Facebook Profile Url', 'aria-describedby' => 'FacebookProfileUrl', 'class' => 'form-control']
                  ], $errors) }}

                  {!! Form::hidden('user_id', $current_user['id']) !!}  

                  {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!} 

              {!! Form::close() !!}
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close('Last Updated yesterday at 11:59 PM') }}

      </div>
    </div>

@endsection