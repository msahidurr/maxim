<?php $__env->startSection('print-body'); ?>

<center>
	<a href="<?php echo e(route('bill_print_view')); ?>" class="print">Print & Preview</a>
</center>



	<?php $__currentLoopData = $headerValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div class="row">
		<div class="col-md-2">
			
		</div>
		<div class="col-md-8">
			<h2><?php echo e($value->header_title); ?></h2>
			<div class="col-md-3">
				<!-- <div class="pull-left"> -->
					FACTORY ADDRESS :
				<!-- </div> -->
			</div>

			<div class="col-md-8">
				<!-- <div class="pull-right"> -->
					<p><?php echo e($value->address1); ?> <?php echo e($value->address2); ?> <?php echo e($value->address3); ?></p>
				<!-- </div> -->
			</div>
		</div>
		<div class="col-md-2"></div>
	</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<div class="row header-bottom">
		<div class="col-md-12 header-bottom-b">
			<span>BILL COPY</span>
		</div>
	</div>

	<div class="row body-top">
		<div class="col-md-6 body-list">
			<!-- <div class="pull-left"> -->
				<!-- <div class="row"> -->
					
					<div class="col-md-3">
						<ul>
							<li>Buyer :</li>
							<li>Sold To :</li>
							<li>Atten :</li>
							<li>Cell :</li>
						</ul>
					</div>
					<div class="col-md-6">
						<ul>
							<li>buyer 1</li>
							<li> s</li>
							<li></li>
						</ul>
					</div>
					
				<!-- </div> -->
				
			<!-- </div> -->
		</div>
		
		<div class="col-md-6 body-list"
			<!-- <div class="pull-right"> -->
			<div class="idid">
				<div class="col-md-3">
					<ul>
						<li>Invo no :</li>
						<li>Date :</li>
					</ul>
				</div>

				<div class="col-md-9">
					<ul>
						<li></li>
						<li></li>
					</ul>
				</div>
			</div>
			
		</div>
	</div>

<div class="row">
	<div class="col-md-12">
		<h4>Dear Sir</h4>
		<p>We take the Plasure in issuing PROFORM INVOICE for the following article (s) on the terms and conditions set forth here under</p>
	</div>
</div>


<table class="table table-bordered">
    <thead>
        <tr>
        	<th width="">Item no/ERP</th>
        	<th width="">Item code</th>
        	<th width="">OSS</th>
            <th width="">Style</th>
            <th width="">Size</th>
            <th width="">Qty/ Pcs</th>
            <th width="">Unit Price/ Pcs</th>
            <th width="">USD Amount</th>
        </tr>
    </thead>
    <tbody>

    		
    </tbody>
    <tfoot>
    	<tr>
    		<!-- <td width="">Total Amount USD</td> -->
    	</tr>
    </tfoot>
</table>


<div class="row body-top">
	<div class="col-md-12 body-list">
		<ul>
			<li>1. TOTAL AMOUNT : USD : </li>
			<li>1. TOTAL AMOUNT : BDt : </li>
		</ul>

		<ul>
			<li>2.Payment Terms : TT/FDD/CHAQUE/CASH BEFORENSHIPMENT</li>
			<li>3.Shipment : By COURIER/ CARGO</li>
			<li>4. Packing : MAXIM STANDARD PACKING</li>
		</ul>
	</div>
</div>


<script type="text/javascript">
		$(document).ready(function(){
			$('.print').printPage();
		});
</script>
<?php
    		// print_r("<pre>");
    		// print_r($arr);
    		// print_r($arr2);
    		// // print_r($arr3);
    		// print_r("<pre>");
    		// print_r($double);die();
    		?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('print_file.layouts.layouts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>