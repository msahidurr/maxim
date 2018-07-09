
<?php $__env->startSection('page_heading', trans("others.mxp_menu_ipo_view") ); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo e(trans('others.mxp_menu_ipo_view')); ?></div>
					<div class="panel-body">
			            
						<form class="form-horizontal" role="form" method="POST" action="<?php echo e(Route('ipo_bill_action')); ?>">
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

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
								<label class="col-md-4 control-label"><?php echo e(trans('others.bill_invo_no_label')); ?></label>
								<div class="col-md-6">
									<input type="text" placeholder="Enter Invoice No" class="form-control  input_required" name="bill_invo_no" value="<?php echo e(old('challan_invo_no')); ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label"><?php echo e(trans('others.initial_increase_label')); ?></label>
								<div class="col-md-6">
									<input type="text" placeholder="Enter initial % increase" class="form-control" name="initial_increase" value="<?php echo e(old('challan_invo_no')); ?>">
								</div>
							</div>
							
							<div class="form-group ">
								<div class="col-md-6 col-md-offset-7">
									<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
										<?php echo e(trans('others.genarate_bill_button')); ?>

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