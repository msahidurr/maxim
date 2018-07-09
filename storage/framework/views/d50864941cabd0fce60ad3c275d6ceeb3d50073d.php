<?php $__env->startSection('page_heading','Unit List'); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
	<div class="col-md-10 col-md-offset-1">
		<div>
			<a href="<?php echo e(Route('add_unit_view')); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'Add new unit'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></a><br><br>
		</div>
		<div>
			<table class="table table-bordered">
	            <thead>
	                <tr>
						<th>SL no.</th>
						<th>Unit Name</th>
						<th>Status</th>
						<th>Action</th>
	                </tr>
	            </thead>
	            <tbody>
	            <?php ($i = 1); ?> 
		            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($unit->name); ?></td>
							<td><?php echo e(($unit->is_active == 1)? 'Active':'Inactive'); ?></td>
							<td> 
								<a href="<?php echo e(Route('edit_unit_view')); ?>/<?php echo e($unit->id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'edit'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
								<a class="delete_id" href="<?php echo e(Route('delete_unit_action')); ?>/<?php echo e($unit->id); ?>/<?php echo e($unit->name); ?>/<?php echo e($unit->is_active); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'danger', 'value'=>'delete'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	            </tbody>
	        </table>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>