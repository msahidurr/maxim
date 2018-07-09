<?php $__env->startSection('page_heading','Product Group List'); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
	<div class="col-md-10 col-md-offset-1">
		<div>
			<a href="<?php echo e(Route('add_product_group_view')); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'Add new product group'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></a><br><br>
		</div>
		<div>
			<table class="table table-bordered">
	            <thead>
	                <tr>
						<th>SL no.</th>
						<th>Product Group Name</th>
						<th>Status</th>
						<th>Action</th>
	                </tr>
	            </thead>
	            <tbody>
	            <?php ($i = 1); ?> 
		            <?php $__currentLoopData = $productGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($productGroup->name); ?></td>
							<td><?php echo e(($productGroup->is_active == 1)? 'Active':'Inactive'); ?></td>
							<td>
								<a href="<?php echo e(Route('edit_productGroup_view')); ?>/<?php echo e($productGroup->id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'edit'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
								<a class="delete_id" href="<?php echo e(Route('delet_productGroup')); ?>/<?php echo e($productGroup->id); ?>/<?php echo e($productGroup->name); ?>/<?php echo e($productGroup->is_active); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'danger', 'value'=>'delete'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	            </tbody>
	        </table>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>