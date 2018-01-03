<?php $__env->startSection('auth_tab_title'); ?>
Reset Password
<?php $__env->stopSection(); ?>

<?php $__env->startSection('auth_title'); ?>
<a href="/"><b>Reset</b>Password</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('auth_content'); ?>


    <p class="login-box-msg">Forgot password</p>
    <?php if(Session::get('pass_send_successfully')): ?>
    <div class="alert alert-success" role="alert">
      <strong>!Success</strong> <?php echo e(Session::get('pass_send_successfully')); ?>

    </div>
    <?php endif; ?>

    <?php echo Form::open(['url' => route('password.email'), 'method' => 'POST']); ?>


      <div class="form-group has-feedback <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
        <?php echo Form::email('email', old('email') , ['placeholder' => 'E-Mail Address', 'aria-describedby' => 'E-MailAddress', 'class' => 'form-control', 'id' => 'useremail']); ?>

        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <?php if($errors->has('email')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('email')); ?></strong>
            </span>
        <?php endif; ?> 
      </div>

  
      <?php echo Form::submit('Send Password Link', ['class' => 'btn btn-primary btn-block']); ?>          
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


    <a href="<?php echo e(route('login')); ?>">Login</a><br />
    <a href="<?php echo e(route('register')); ?>">Register an Account</a>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.userauth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>