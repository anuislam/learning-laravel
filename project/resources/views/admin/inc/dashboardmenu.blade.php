
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
      <a href="{{ route('user.create') }}">Add User</a>
    </li>
  </ul>
</li>

<?php $menus = admin_menu_setup() ?>
@if(isset($menus))
  @if(is_array($menus))

    @foreach($menus as $menu)
      @if(isset($menu['tarms']))

      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="{{ (isset($menu['title'])) ? $menu['title'] : '' }}">
        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#{{ (isset($menu['slug'])) ? $menu['slug'] : '' }}" data-parent="#dashboardMenu">
          <i class="fa fa-fw fa-users"></i>
          <span class="nav-link-text">{{ (isset($menu['title'])) ? $menu['title'] : '' }}</span>
        </a>

          @if(is_array($menu['tarms']))
        <ul class="sidenav-second-level collapse" id="{{ (isset($menu['slug'])) ? $menu['slug'] : '' }}">
          @foreach($menu['tarms'] as $children_menu)
            <li>
              <a href="{{ route('user.index') }}">{{ (isset($children_menu['title'])) ? $children_menu['title'] : '' }}</a>
            </li>
          @endforeach
        </ul>         
        @endif
      </li>
      @else
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="fa fa-fw fa-dashboard"></i>
          <span class="nav-link-text">Dashboard</span>
        </a>
      </li>
      @endif
    @endforeach

  @endif
@endif



</ul>
