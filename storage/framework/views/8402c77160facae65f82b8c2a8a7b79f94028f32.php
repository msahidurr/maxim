<?php $__env->startSection('page_heading', trans("others.mxp_menu_mrf_list") ); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<table class="table table-bordered table-striped ">
				<tr>
					<thead>
						<th>Serial no</th>
						<th>booking id</th>
						<th>MRF Id</th>
						<th>MRF Create Date</th>
						<th>MRF Shipment Date</th>
						<th>Action</th>
					</thead>
				</tr>
				<?php ($j=1); ?>
				<?php $__currentLoopData = $bookingList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td><?php echo e($j++); ?></td>
					<td><?php echo e($value->booking_order_id); ?></td>
					<td><?php echo e($value->mrf_id); ?></td>
					<td><?php echo e(Carbon\Carbon::parse($value->created_at)); ?></td>
					<td></td>
					<td></td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>