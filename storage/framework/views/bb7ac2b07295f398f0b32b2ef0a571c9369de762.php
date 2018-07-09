<?php $__env->startSection('page_heading',trans('others.heading_chart_of_acc_list_label')); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
	<div class="col-md-10 col-md-offset-1">
		<div>
			<a href="<?php echo e(Route('chart_of_acc_create_view')); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'Add Chart of Account'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></a><br><br>
		</div>
		<div>
			<table class="table table-bordered">
	            <thead>
	                <tr>
						<th><?php echo e(trans('others.serial_no_label')); ?></th>
						<th>Chart of Account name</th>
						<th>Account sub head class name</th>
						<th>Account head class name</th>
						<th>Account head/type</th>
						<th>Account sub head/type</th>
						<th><?php echo e(trans('others.status_label')); ?></th>
						<th><?php echo e(trans('others.action_label')); ?> </th>
	                </tr>
	            </thead>
	            <tbody>
	            <?php ($i = 1); ?> 
		            <?php $__currentLoopData = $chart_of_accs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chart_of_acc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($chart_of_acc->acc_final_name); ?></td>
							<td><?php echo e($chart_of_acc->head_sub_class_name); ?></td>
							<td><?php echo e($chart_of_acc->head_class_name); ?></td>
							<td><?php echo e($chart_of_acc->account_head_details); ?></td>
							<td><?php echo e($chart_of_acc->sub_head); ?></td>
							<td><?php echo e(($chart_of_acc->is_active == 1)? trans('others.action_active_label'):trans('others.action_inactive_label')); ?></td>
							<td> 
								<a href="<?php echo e(Route('chart_of_acc_update_view')); ?>/<?php echo e($chart_of_acc->chart_o_acc_head_id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>trans('others.edit_button')), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
								<a class="delete_id" href="<?php echo e(Route('chart_of_acc_delete_action')); ?>/<?php echo e($chart_of_acc->chart_o_acc_head_id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'danger', 'value'=>trans('others.delete_button')), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	            </tbody>
	        </table>
		</div>
	</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>