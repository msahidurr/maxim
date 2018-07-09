<?php $__env->startSection('page_heading', trans("others.mxp_menu_order_list") ); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<table class="table table-bordered table-striped ">
				<tr>
					<thead>
						<th>Serial no</th>
						<th>Buyer Name</th>
						<th>Company Name</th>
						<th>Attention</th>
						<th>Mobile</th>
						<th>Invo No</th>
						<th>Create Time</th>
					</thead>
				</tr>
				<?php ($j=1); ?>
				<?php $__currentLoopData = $orderList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td><?php echo e($j++); ?></td>
					<td><?php echo e($value->name_buyer); ?></td>
					<td><?php echo e($value->name); ?></td>
					<td><?php echo e($value->attention_invoice); ?></td>
					<td><?php echo e($value->mobile_invoice); ?></td>
					<td><?php echo e($value->bill_id); ?></td>
					<td><?php echo e(Carbon\Carbon::parse($value->created_at)); ?></td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>

			<?php echo e($orderList->links()); ?>

		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>