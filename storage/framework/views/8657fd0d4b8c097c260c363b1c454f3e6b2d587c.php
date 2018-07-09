<?php $__env->startSection('page_heading','Store List'); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
	<div class="col-md-10 col-md-offset-1">
		<div>
			<a href="<?php echo e(Route('add_store_view')); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'Add new store'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></a><br><br>
		</div>
		<div>
			<table class="table table-bordered">
	            <thead>
	                <tr>
						<th>SL no.</th>
						<th>Store Name</th>
						<th>Store Location</th>
						<th>Status</th>
						<th>Action</th>
	                </tr>
	            </thead>
	            <tbody>
	            <?php ($i = 1); ?> 
		            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($store->name); ?></td>
							<td><?php echo e($store->location); ?></td>
							<td><?php echo e(($store->status == 1)? 'Active':'Inactive'); ?></td>
							<td> 
								<a href="<?php echo e(Route('edit_store_action')); ?>/<?php echo e($store->id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'edit'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
								<a class="delete_id" href="<?php echo e(Route('delete_store_action')); ?>/<?php echo e($store->id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'danger', 'value'=>'delete'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	            </tbody>
	        </table>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>