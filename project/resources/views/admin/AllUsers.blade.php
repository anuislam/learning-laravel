@extends('layouts.dashboard')

@section('dashboard_tab_title')
Admin Dashboard
@endsection


@section('dashboard_content')
    <section class="content-header">
      <h1>
        Add New Media
        <small>Control panel</small>
      </h1>
      {{ Breadcrumbs::render('alluser') }}
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
    

{{ heml_card_open('fa fa-user', 'All Users') }}

          <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
            tarms-url="{{ route('user-datatable') }}"
            tarms-data="{{ json_encode([
                            [
                              'data' => 'profile',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                              ],
                            ['data' => 'fname'],
                            ['data' => 'lname'],
                            ['data' => 'email'],
                            [
                              'data'     => 'created_at',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                            ],
                            [
                              'data'     => 'roll',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                            ],
                            [
                              'data'     => 'action',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                            ]
                          ]) }}"
          >
            <thead>
              <tr>
                <th width="30" class="text-center">Profile</th>
                <th>Frist Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>join At</th>
                <th>Roll</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Profile</th>
                <th>Frist Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>join At</th>
                <th>Roll</th>
                <th>Actions</th>
              </tr>
            </tfoot>
          </table>
{{ heml_card_close() }}
</section>
    <!-- end datatable -->

@endsection