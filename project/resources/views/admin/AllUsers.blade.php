@extends('layouts.dashboard')

@section('dashboard_tab_title')
Admin Dashboard
@endsection


@section('dashboard_content')
    <!-- Breadcrumbs-->
    @include('admin.inc.breadcrumb')



<!-- Start datatalbe -->


    
    <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-table"></i> All Users</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
            <tbody>           
            @if( $get_all_users !== false )   
              @foreach ($get_all_users as $user)
                <tr>
                  <td>
                    <img src="{{ $user['profile'] }}" alt="profile" width="35" height="35">
                  </td>
                  <td>{{ $user['fname'] }}</td>
                  <td>{{ $user['lname'] }}</td>
                  <td>{{ $user['email'] }}</td>
                  <td>{{ $user['created_at'] }}</td>
                  <td>{{ $user['roll'] }}</td>
                  <td><a href="" class="btn btn-secondary">Edith</a> <a href="" class="btn btn-danger">Delete</a></td>
                </tr>
              @endforeach
            @endif
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div>

    <!-- end datatable -->

@endsection