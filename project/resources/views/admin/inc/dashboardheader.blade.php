        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          {!! $notification !!}
 
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              {{ Html::image(($current_user['avatar']) ? $current_user['avatar'] : get_gravatar_custom_img($current_user['email'], 25), $current_user['fname'].' '. $current_user['lname'], array('class' => 'user-image')) }}
              <span class="hidden-xs"> {{$current_user['fname'].' '. $current_user['lname']}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                {{ Html::image(
                    ($current_user['avatar']) ? $current_user['avatar'] : get_gravatar_custom_img($current_user['email'], 160), $current_user['fname'].' '. $current_user['lname'], array('class' => 'img-circle')) }}

                <p>
                  {{$current_user['fname'].' - '. $current_user['lname']}}
                  <small>Member since {{ Carbon\Carbon::parse($current_user['created_at'])->format('M. Y') }}</small>
                </p>
              </li>

              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('user.index') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a 


            class="btn btn-default btn-flat" 
            onclick="data_modal(this)" 
            data-title="Ready to Leave?"
            data-message='Select "Logout" below if you are ready to end your current session.'
            cancel_text="Cancel"
            submit_text="Logout"
            data-type="post"
            data-parameters='{"_token":"{{ csrf_token() }}"}'

            href="{{ route('logout') }}" 

                  >Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>        
