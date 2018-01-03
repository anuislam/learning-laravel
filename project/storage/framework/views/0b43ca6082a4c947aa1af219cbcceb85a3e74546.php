<?php $__env->startSection('auth_tab_title'); ?>
Login
<?php $__env->stopSection(); ?>

<?php $__env->startSection('auth_title'); ?>
<a href="/"><b>Login</b>LTE</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('auth_content'); ?>

    <p class="login-box-msg">Sign in to start your session</p>
    <?php echo Form::open(['url' => route('login'), 'method' => 'POST']); ?>


      <div class="form-group has-feedback <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
        <?php echo Form::email('email', old('email') , ['placeholder' => 'Enter email', 'aria-describedby' => 'emailHelp', 'class' => 'form-control', 'id' => 'useremail']); ?>

        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <?php if($errors->has('email')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('email')); ?></strong>
            </span>
        <?php endif; ?> 
      </div>

      <div class="form-group has-feedback <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
        <?php echo Form::password('password', ['class' => 'form-control', 'id' => 'userpassword', 'placeholder' => 'Password']); ?>

        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?php if($errors->has('password')): ?>
          <span class="help-block">
            <strong><?php echo e($errors->first('password')); ?></strong>
          </span>
        <?php endif; ?>
      </div>


      <div class="row">

        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <?php echo Form::checkbox('remember', 'yes', false); ?> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <?php echo Form::submit('Sign In', ['class' => 'btn btn-primary btn-block btn-flat']); ?>

        </div>
        <!-- /.col -->
      </div>

    <?php echo Form::close(); ?>


    <div class="social-auth-links text-center">
		<p>- OR -</p>
		<a href="#" class="btn btn-block btn-social btn-facebook">
			<i class="fa fa-facebook"></i> 
			Sign in using Facebook
		</a>
		<a href="#" class="btn btn-block btn-social btn-google">
			<i class="fa fa-google-plus"></i> 
			Sign in using Google+
		</a>
		<a class="btn btn-block btn-social btn-twitter">
			<i class="fa fa-twitter"></i> 
			Sign in using Twitter
		</a>
    </div>
    <!-- /.social-auth-links -->

    <a href="<?php echo e(route('password.request')); ?>">I forgot my password</a><br>
    <a href="<?php echo e(route('register')); ?>" >Register a new membership</a>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.userauth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>