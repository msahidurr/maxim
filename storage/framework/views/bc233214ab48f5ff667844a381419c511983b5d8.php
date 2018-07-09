<center>
	<a href="<?php echo e(route('bill_print_view')); ?>" class="print">Print & Preview</a>
</center>
<?php $__currentLoopData = $headerValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="row">
	<div class="col-md-2">
		
	</div>
	<div class="col-md-8">
		<h2><?php echo e($value->header_title); ?></h2>
		<!-- <h2>Maxim Label & packaging Bangladesh Pvt; Ltd</h2> -->
		<div class="col-md-3 pull-left">FACTORY ADDRESS :</div>
			<div class="col-md-8 pull-right">
			<span> Section-02, Block-D, Road-01 </span>
			</div>
	</div>
	<div class="col-md-2"></div>
</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



