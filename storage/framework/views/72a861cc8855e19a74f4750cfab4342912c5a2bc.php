<?php $__env->startSection('page_heading','Product'); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
	<div class="col-md-10 col-md-offset-1">
		<div>
			<a href="<?php echo e(Route('add_product_entry_view')); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'Add new product'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></a><br><br>
		</div>
		<div>
			<table class="table table-bordered">
	            <thead>
	                <tr>
						<th>SL no.</th>
						<th>Product Details</th>
						<th>Group</th>
						<th>Status</th>
						<th>Action</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php ($i = 1); ?>
		            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($product->packet_name); ?></td>
							<td><?php echo e($product->pord_grp_name); ?></td>
							<td><?php echo e(($product->is_active == 1)? 'Active':'Inactive'); ?></td>
							<td>
								<a href="<?php echo e(Route('edit_product_entry_view')); ?>/<?php echo e($product->group_id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'edit'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
								<a class="delete_id" href="<?php echo e(Route('delete_product_entry_action')); ?>/<?php echo e($product->id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'danger', 'value'=>'delete'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	            </tbody>
	        </table>
		</div>
	</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>