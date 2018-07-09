<?php $__env->startSection('page_heading',trans('others.heading_sub_accounts_head_list_label')); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
	<div class="col-md-10 col-md-offset-1">
		<div>
			<a href="<?php echo e(Route('add_sub_accounts_head_view')); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'Add Account head/type'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></a><br><br>
		</div>
		<div>
			<table class="table table-bordered">
	            <thead>
	                <tr>
						<th><?php echo e(trans('others.serial_no_label')); ?></th>
						<th>Account head/type</th>
						<th>Account sub head/type</th>
						<th><?php echo e(trans('others.status_label')); ?></th>
						<th><?php echo e(trans('others.action_label')); ?> </th>
	                </tr>
	            </thead>
	            <tbody>
	            <?php ($i = 1); ?> 
		            <?php $__currentLoopData = $sub_accounts_heads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_accounts_head): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($sub_accounts_head->account_head_details); ?></td>
							<td><?php echo e($sub_accounts_head->sub_head); ?></td>
							<td><?php echo e(($sub_accounts_head->is_active == 1)? trans('others.action_active_label'):trans('others.action_inactive_label')); ?></td>
							<td> 
								<a href="<?php echo e(Route('edit_sub_accounts_head_view')); ?>/<?php echo e($sub_accounts_head->accounts_sub_heads_id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>trans('others.edit_button')), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
								<a class="delete_id" href="<?php echo e(Route('delete_sub_accounts_head_action')); ?>/<?php echo e($sub_accounts_head->accounts_sub_heads_id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'danger', 'value'=>trans('others.delete_button')), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	            </tbody>
	        </table>
		</div>
	</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>