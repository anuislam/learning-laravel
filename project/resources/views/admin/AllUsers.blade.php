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
                <th>Profile</th>
                <th>Frist Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Age</th>
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
                <th>Age</th>
                <th>join At</th>
                <th>Roll</th>
                <th>Actions</th>
              </tr>
            </tfoot>
            <tbody>             
              <tr>
                <td><img src="{{ url('public/images/IMG_20151204_230431.jpg') }}" alt="profile" width="35" height="35"></td>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                <td>2011/01/25</td>
                <td>admin</td>
                <td><a href="" class="btn btn-secondary">Edith</a> <a href="" class="btn btn-danger">Delete</a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div>

    <!-- end datatable -->

@endsection