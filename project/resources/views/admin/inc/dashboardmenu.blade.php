
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          {{ Html::image(($current_user['avatar']) ? $current_user['avatar'] : get_gravatar_custom_img($current_user['email'], 160), $current_user['fname'].' '. $current_user['lname'], array('class' => 'img-circle')) }}
        </div>
        <div class="pull-left info">
          <p>{{$current_user['fname'].' '. $current_user['lname']}}</p>
          <a href="{{ route('user.index') }}"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

		{{ get_admin_sidebar_menu($current_user['id']) }}

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
