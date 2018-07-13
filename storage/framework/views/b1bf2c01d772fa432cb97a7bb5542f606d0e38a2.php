<?php $__env->startSection('page_heading', trans("others.mxp_menu_challan_list")); ?>
<?php $__env->startSection('section'); ?>
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<table class="table table-bordered">
				<tr>
					<thead>
						<th>Serial no</th>
						<th>booking id</th>
						<th>Challan Id</th>
						<th>Create Date</th>
						<th>Action</th>
					</thead>
				</tr>
				<?php ($j=1); ?>
				<?php $__currentLoopData = $challanDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td><?php echo e($j++); ?></td>
					<td><?php echo e($value->checking_id); ?></td>
					<td><?php echo e($value->challan_id); ?></td>
					<td><?php echo e(Carbon\Carbon::parse($value->created_at)); ?></td>
					<td>
						<form action="<?php echo e(Route('challan_list_action_task')); ?>" role="form" target="_blank">
							<input type="hidden" name="cid" value="<?php echo e($value->challan_id); ?>">
							<input type="hidden" name="bid" value="<?php echo e($value->checking_id); ?>">
							<button class="btn btn-success" target="_blank">View</button>
						</form>
					</td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>