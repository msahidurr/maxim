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
					<?php ($i=0); ?>
					<?php $__currentLoopData = $sentBillId; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Datils): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php for($i;$i <= 0;$i++): ?>
					<div class="col-md-6">
						<ul>
							<li><?php echo e($Datils->name_buyer); ?></li>
							<li><?php echo e($Datils->name); ?></li>
							<li><?php echo e($Datils->attention_invoice); ?></li>
						</ul>
					</div>
					<?php endfor; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<!-- </div> -->
				
			<!-- </div> -->
		</div>
		
		<div class="col-md-6">
			<?php ($i=0); ?>
			<?php $__currentLoopData = $sentBillId; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $billdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php for($i;$i <= 0;$i++): ?>
				<table class="tables table-bordered" style="width: 100%;">
					<tr>
						<td>
							<div style="text-align: right;">
								<p style="padding-left :5px;"> Invo no : <?php echo e($billdata->bill_id); ?></p>
							</div>
						</td>
					</tr>
					<div class="col-md-6"></div>
					<div class="col-md-6">
						<tr>
							<td>
								<div style="text-align: right;">
								<p style="padding-left :5px;"> Date : <?php echo e(Carbon\Carbon::parse($billdata->created_at)->format('Y-m-d')); ?></p>
							</div>
							</td>
						</tr>
					</div>
				</table>
			<?php endfor; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
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
        	<th width="15%">Item no/ERP</th>
        	<th width="15%">Item code</th>
        	<th width="10%">OSS</th>
            <th width="10%">Style</th>
            <th width="14%">Size</th>
            <th width="6%">Qty/ Pcs</th>
            <th width="10%">Unit Price/ Pcs</th>
            <th width="10%">USD Amount</th>
        </tr>
    </thead>
    <tbody>
    	<?php
    		$i = 0;    		
    		$totalAllQty = 0;
    		$totalUsdAmount = 0;
    		$BDTandUSDavarage = 80;
    	 ?>
    		<?php $__currentLoopData = $sentBillId; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    			<?php
    				$totalQty =0;
    				$itemsize = explode(',', $item->item_size);  				
    				$qty = explode(',', $item->quantity);
    				$itemlength = 0;
    				foreach ($itemsize as $itemlengths) {
    					$itemlength = sizeof($itemlengths);
    				}
    				$itemQtyValue = array_combine($itemsize, $qty);   				
    			?>
    			
    			
	    			<tr>
	    				<td rowspan="<?php echo e($itemlength); ?>"><?php echo e($item->erp_code); ?></td>
	    				<td rowspan="<?php echo e($itemlength); ?>"><?php echo e($item->item_code); ?></td>
	    				<td rowspan="<?php echo e($itemlength); ?>"></td>
			    		<td rowspan="<?php echo e($itemlength); ?>"></td> 
			    		
			    			<?php if($itemlength >= 1 ): ?>
				    			<td colspan="2" class="colspan-td">  				
				    				<table>
				    					<?php $__currentLoopData = $itemQtyValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size => $Qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				    					<?php 
				    						$i++;
				    						$totalQty += $Qty; 
				    					?>
				    					<tr>
				    						<td width="70%"><?php echo e($size); ?></td>
							    			<td width="30%"><?php echo e($Qty); ?></td>
				    					</tr>
				    					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				    					<?php if( $i > 1 ): ?>
				    					<tr>
				    						<td width="70%"></td>
				    						<td width="30%"><?php echo e($totalQty); ?></td>
				    					</tr>
				    					<?php endif; ?>
				    				</table>
				    			</td>
				    		<?php endif; ?>			    		   
			    		<td rowspan="<?php echo e($itemlength); ?>"><?php echo e($item->unit_price); ?></td>
			    		
			    		<?php 
    						$totalAllQty += $totalQty;
    						$UsdAmount = $totalQty * $item->unit_price;
    						$totalUsdAmount += $UsdAmount;
    					?>
    					<td><?php echo e($UsdAmount); ?></td>
	    			</tr>
    		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    	<?php 
    		$BDTandUSD = $BDTandUSDavarage * $totalUsdAmount;
    		$totalAllQty = str_replace(",","",$totalAllQty);
    		$totalUsdAmount = number_format($totalAllQty, 2, '.', '');
    		$BDTandUSD = number_format($BDTandUSD, 2, '.', '');
    	?>
    	<tr>
			<td colspan="5"><div style="text-align: center; font-weight: bold;font-size: ;"><span>Total Qty </span></div></td>
			<td><?php echo e($totalAllQty); ?></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="7"><div style="text-align: center;font-weight: bold;font-size: ;"><span> Total Amount USD </span></div></td>
			<td><?php echo e($totalUsdAmount); ?></td>
		</tr>
		<tr>
			<td colspan="6"><div style="text-align: center;font-weight: bold;font-size: ;"><span> Total Amount BDT </span></div></td>
			<td><?php echo e($BDTandUSDavarage); ?></td>
			<td><?php echo e($BDTandUSD); ?></td>
		</tr>
    		
    </tbody>
    <tfoot>
    	<tr>
    		<!-- <td width="">Total Amount USD</td> -->
    	</tr>
    </tfoot>
</table>

<div class="row">
	<div class="col-md-12">
		<table  border="5px solid #DBDBDB" class="table table-bordered">
			<tr>
				<td>
					<div style="text-align:;font-weight: bold;">
						<span>1. TOTAL AMOUNT : USD :</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div style="text-align:;font-weight: bold;">
						<span>1. TOTAL AMOUNT : BDT :</span>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="row body-top">
	<div class="col-md-12 body-list">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('print_file.layouts.layouts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>