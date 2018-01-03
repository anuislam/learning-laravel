<?php $__env->startSection('auth_tab_title'); ?>
Registration
<?php $__env->stopSection(); ?>

<?php $__env->startSection('auth_title'); ?>
<a href="/"><b>Registration</b>LTE</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('auth_content'); ?>

    <p class="login-box-msg">Register a new membership</p>
    <?php echo Form::open(['url' => route('register'), 'method' => 'POST']); ?>





      <div class="form-group has-feedback <?php echo e($errors->has('fname') ? ' has-error' : ''); ?>">

        <?php echo Form::text('fname', old('fname') , [
            'placeholder' => 'Frist Name', 
            'class' => 'form-control', 
            'required' => '', 
            'autofocus' => '', 
            'id' => 'fname'
            ]); ?>   

        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <?php if($errors->has('fname')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('fname')); ?></strong>
            </span>
        <?php endif; ?>

      </div>

      <div class="form-group has-feedback <?php echo e($errors->has('lname') ? ' has-error' : ''); ?>">
            <?php echo Form::text('lname', old('lname') , [
                'placeholder' => 'Last Name',
                'class' => 'form-control',
                'required' => '', 
                'autofocus' => '', 
                'id' => 'lname'
                ]); ?>   

        <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <?php if($errors->has('lname')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('lname')); ?></strong>
                </span>
            <?php endif; ?> 
      </div>

      <div class="form-group has-feedback <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
            <?php echo Form::email('email', old('email') , [
                'placeholder' => 'Enter email', 
                'aria-describedby' => 'emailHelp', 
                'class' => 'form-control', 
                'required' => '', 
                'autofocus' => '',
                'id' => 'useremail'
            ]); ?>  

            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <?php if($errors->has('email')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('email')); ?></strong>
                </span>
            <?php endif; ?> 
      </div>

      <div class="form-group has-feedback <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
            <?php echo Form::password('password', [
                'class' => 'form-control', 
                'id' => 'userpassword', 
                'required' => '', 
                'autofocus' => '',
                'placeholder' => 'Password'
            ]); ?>


        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <?php if($errors->has('password')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('password')); ?></strong>
                </span>
            <?php endif; ?> 
      </div>

      <div class="form-group has-feedback <?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
            <?php echo Form::password('password_confirmation', [
                'class' => 'form-control', 
                'id' => 'userpassword', 
                'required' => '', 
                'autofocus' => '',
                'placeholder' => 'Confirm Password'
            ]); ?>


        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            <?php if($errors->has('password_confirmation')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                </span>
            <?php endif; ?> 
      </div>


      <div class="row">

        <div class="col-xs-8 <?php echo e($errors->has('agreement') ? ' has-error' : ''); ?>">
          <div class="checkbox icheck">
            <label>
              <?php echo Form::checkbox('agreement', 'yes', false); ?> I agree to the <a href="#">terms
            </label>
          </div>

        <?php if($errors->has('agreement')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('agreement')); ?></strong>
            </span>
        <?php endif; ?>

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

    <a href="<?php echo e(route('login')); ?>" class="text-center">Login</a>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.userauth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>