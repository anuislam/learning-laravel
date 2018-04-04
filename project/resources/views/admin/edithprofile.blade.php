@extends('layouts.dashboard')

@section('dashboard_tab_title')
Edith User | Website
@endsection


@section('dashboard_content')
    <section class="content-header">
      <h1>
        Edith 
        <small>User</small>
      </h1>
       @include('admin.inc.breadcrumb')
    </section>

  <section class="content">
        @if(Session::get('error_msg'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> Error!</h4>
          {{ Session::get('error_msg') }}
        </div>

        @endif

        @if(Session::get('success_msg'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ Session::get('success_msg') }}
              </div>
        @endif
        
    <div class="row">
      <div class="col-md-8">

{{ heml_card_open('fa fa-user', 'Edith User') }}

            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-12">



          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black" style="background: url('{{asset('public').'/admin/dist/img/photo1.png'}}') center center;">
              <h3 class="widget-user-username">{{ $edith_user['fname'].' '. $edith_user['lname'] }}</h3>
              <h5 class="widget-user-desc">Web Designer</h5>
            </div>
            <div class="widget-user-image">

                    {{ Html::image(get_gravatar_custom_img($edith_user['email'], 200), $edith_user['fname'], array('class' => 'img-circle', 'alt' => 'User Avatar')) }}

            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">3,200</h5>
                    <span class="description-text">SALES</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">13,000</h5>
                    <span class="description-text">FOLLOWERS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">35</h5>
                    <span class="description-text">PRODUCTS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>


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
                    'atts' =>  ['aria-describedby' => 'Userrool', 'class' => 'form-control', 'class' => 'form-control select2', 'style' => 'width: 100%;'],
                    'items' =>   $userpermission->get_roles_name(),
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

                  {!! Form::submit('Update', ['class' => 'btn bg-olive btn-flat']) !!} 

              {!! Form::close() !!}
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close() }}

      </div>
    </div>

</section>
@endsection