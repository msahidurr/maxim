<?php $__env->startSection('page_heading', trans("others.add_product_size_label") ); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
    <div class="container-fluid">
		<?php if($errors->any()): ?>
		    <div class="alert alert-danger">
		        <ul>
		            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                <li><?php echo e($error); ?></li>
		            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		        </ul>
		    </div>
		<?php endif; ?>

		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo e(trans('others.add_size_label')); ?></div>
					<div class="panel-body">
			            
			            <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<form class="form-horizontal" role="form" method="POST" action="<?php echo e(Route('update_size_action')); ?>\<?php echo e($values->proSize_id); ?>">
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">							

						
						<div class="col-md-12">

							<div class="form-group col-md-6">
								<label class="col-md-4 control-label"><?php echo e(trans('others.product_code_label')); ?></label>
								<div class="col-md-8">
									<select class="form-control" name="p_code" >
										<option value="<?php echo e($values->product_code); ?>" name="p_code"><?php echo e($values->product_code); ?></option>
										<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($product->product_code); ?>" name="p_code"><?php echo e(($values->product_code === $product->product_code)?:$product->product_code); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
							</div>	

							<div class="form-group col-md-6">
								<label class="col-md-4 control-label"><?php echo e(trans('others.product_size_label')); ?></label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="p_size" value="<?php echo e($values->product_size); ?>">
								</div>
							</div>
						</div>
						

						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-3 col-md-offset-5">
									<div class="select">
										<select class="form-control" type="select" name="isActive" >
											<option  value="1" name="isActive" ><?php echo e(trans("others.action_active_label")); ?></option>
											<option value="0" name="isActive" ><?php echo e(trans("others.action_inactive_label")); ?></option>
									    </select>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-6 col-md-offset-5">
									<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
										<?php echo e(trans('others.update_button')); ?>

									</button>
								</div>
							</div>

						</div>
						</form>

						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>