<?php $__env->startSection('page_heading', trans("others.update_language_label")); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo e(trans("others.update_language_label")); ?></div>
				<div class="panel-body">

					<form class="form-horizontal" role="form" method="POST" action="<?php echo e(Route('update_locale_action')); ?>">
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
						<input type="hidden" name="id" value="<?php echo e($language->id); ?>">

						<?php if($errors->any()): ?>
						    <div class="alert alert-danger">
						        <ul>
						            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						                <li><?php echo e($error); ?></li>
						            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						        </ul>
						    </div>
						<?php endif; ?>

						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo e(trans('others.update_language_title')); ?></label>
							<div class="col-md-6">
								<input type="text" class="form-control input_required" name="lan_name" value="<?php echo e($language->lan_name); ?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo e(trans('others.update_language_code')); ?></label>
							<div class="col-md-6">
								<input type="text" class="form-control input_required" name="lan_code"  value="<?php echo e($language->lan_code); ?>">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-3 col-md-offset-4">
								<div class="select">
									<select class="form-control" type="select" name="isActive" >
										<option  value="1" name="isActive" <?php echo e(($language->is_active == 1)? 'selected' : ''); ?>><?php echo e(trans("others.action_active_label")); ?> </option>
										<option value="0" name="isActive" <?php echo e(($language->is_active == 0) ? 'selected' : ''); ?>><?php echo e(trans("others.action_inactive_label")); ?> </option>
					   				</select>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
									<?php echo e(trans('others.update_button')); ?>

								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>