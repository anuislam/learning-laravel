
<ul class="navbar-nav navbar-sidenav" id="#dashboardMenu">



<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
  <a class="nav-link" href="{{ route('dashboard') }}">
    <i class="fa fa-fw fa-dashboard"></i>
    <span class="nav-link-text">Dashboard</span>
  </a>
</li>



<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
  <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseUsers" data-parent="#dashboardMenu">
    <i class="fa fa-fw fa-users"></i>
    <span class="nav-link-text">Users</span>
  </a>
  <ul class="sidenav-second-level collapse" id="collapseUsers">
    <li>
      <a href="{{ route('user.index') }}">Your Profile</a>
    </li>
    <li>
      <a href="{{ route('all-users') }}">All Users</a>
    </li>
    <li>
      <a href="cards.html">Add User</a>
    </li>
  </ul>
</li>



</ul>
