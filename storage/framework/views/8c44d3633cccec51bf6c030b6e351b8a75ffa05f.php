<?php $__env->startSection('print-body'); ?>

<style type="text/css">
	.header-top-a .buyerName{
		padding-left: 40px;
	}
	.valueGenarate table{
		width: 100%;
	}
	.valueGenarate table tr td{
		text-align: right;
		padding-right: 5px;
	}
	.valueGenarate table tr td p{
		font-weight: bold;
	}
	.mainBody table thead>th{
		align: center;
	}
	.mainBody .grandTotal{
		text-align: center;
	}
	.mainBody .grandTotal span{
		font-weight: bold;
	}
</style>

	<center>
		<a href="#" onclick="myFunction()" class="print">Print & Preview</a>
	</center>


	<?php $__currentLoopData = $buyerDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<div class="row header-top-a">
			<div class="col-md-2 col-sm-2">
				
			</div>
			<div class="col-md-8 col-sm-8 buyerName">
				<h2 align="center"><?php echo e($details->buyer_name); ?></h2>
			</div>
			<div class="col-md-2 col-sm-2"></div>
		</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<div class="row header-bottom">
		<div class="col-md-12 col-sm-12 header-bottom-b">
			<span>Internal Purchase Order</span>
		</div>
		<hr>
	</div>

	<div class="row body-top">
		<div class="col-md-6 col-sm-6 col-xs-7 body-list">
			<?php $__currentLoopData = $buyerDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<ul>
					<li><strong>Booking ID: <?php echo e($details->booking_order_id); ?></strong></li>
					<li><strong>Company Name: <?php echo e($details->buyer_name); ?></strong></li>
					<li><h5>Date : <?php echo e(Carbon\Carbon::now()->format('Y-m-d')); ?></h5></li>
				</ul>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
		
		<div class="col-md-6 col-sm-6 col-xs-5 valueGenarate">
			<?php ($i=0); ?>
			<?php $__currentLoopData = $sentBillId; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $billdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php for($i;$i <= 0;$i++): ?>
				<table class="tables table-bordered">
					<tr>
						<td colspan="2">
							<div>
								<p>MAY PORTION</p>
							</div>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<div>
								<p>Checking No : <?php echo e($billdata->ipo_id); ?></p>
							</div>
						</td>
					</tr>
				</table>
			<?php endfor; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
		</div>
	</div>
<?php $increase = $initIncrease; ?>
<table class="table table-bordered mainBody">
    <thead>
    	<tr>
        	<th width="5%">SI</th>
        	<th width="10%">PO/CAT</th>
        	<th width="10%">Item code</th>
        	<th width="15%">Description</th>
        	<th width="10%">Size</th>
        	<th width="10%">TOTAL PCS/MTR</th>
        	<th width="10%"><?php echo e($increase); ?>%</th>
        	<th width="10%">1ST DELIVERY</th>
            <th width="10%">Request Date</th>
            <th width="10%">Confirmation Date</th>
        </tr>
    </thead>
    <tbody> 
    	<?php
    		$j = 1;
    		$totalAllQty = 0;
    		$totalAllIncrQty = 0;
    		$totalUsdAmount = 0;
    		$BDTandUSDavarage = 80;
    		$rowspanValue = 0;
    	 ?>
    	 	<?php $__currentLoopData = $sentBillId; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    	 		<?php
    	 			$count = 1;
    	 			$rowspanValue += $count;
    	 		 ?>
    	 	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    		<?php $__currentLoopData = $sentBillId; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    			<?php
    				$i = 0;
    				$k = 0;    		
    				$totalQty =0;
    				$totalIncrQty = 0;
    				$itemsize = explode(',', $item->item_size);  				
    				$qty = explode(',', $item->item_quantity);
    				$itemlength = 0;
    				foreach ($itemsize as $itemlengths) {
    					$itemlength = sizeof($itemlengths);
    				}
    				$itemQtyValue = array_combine($itemsize, $qty);		
    			?>
    			
    			
	    			<tr>
	    				<td><?php echo e($j++); ?></td>
	    				<td rowspan="<?php echo e($itemlength); ?>"><?php echo e($item->poCatNo); ?></td>
	    				<td rowspan="<?php echo e($itemlength); ?>"><?php echo e($item->item_code); ?></td>
	    				<td rowspan="<?php echo e($itemlength); ?>"><?php echo e($item->erp_code); ?></td>			    		
			    			<?php if($itemlength >= 1 ): ?>
				    			<td colspan="2" class="colspan-td">  				
				    				<table >
				    					<?php $__currentLoopData = $itemQtyValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size => $Qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				    					<?php 
				    						$i++;
				    						$totalQty += $Qty; 
				    					?>
				    					<tr>
				    						<td width="50%"><?php echo e($size); ?></td>
							    			<td width="50%"><?php echo e($Qty); ?></td>
				    					</tr>
				    					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				    					<?php if( $i > 1 ): ?>
				    					<tr>
				    						<td></td>
				    						<td width="100%"><?php echo e($i); ?><?php echo e($totalQty); ?></td>
				    					</tr>
				    					<?php endif; ?>
				    				</table>
				    			</td>
				    			<td class="colspan-td">
				    			<div class="middel-table">
				    				<table>
				    					<?php $__currentLoopData = $itemQtyValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size => $Qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				    					<?php 
				    						$k++;
				    						$totalIncrQty += ceil(($Qty*$increase)/100 + $Qty); 
				    					?>
				    					<tr>
							    			<td width="100%"><?php echo e(ceil(($Qty*$increase)/100 + $Qty)); ?>

							    			</td>
				    					</tr>
				    					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				    					<?php if( $k > 1 ): ?>
				    					<tr>
				    						<td width="100%"><?php echo e($totalIncrQty); ?></td>
				    					</tr>
				    					<?php endif; ?>
				    				</table>
				    				</div> 				
				    			</td>
				    		<?php endif; ?>			    		   
			    		<?php 
    						$totalAllQty += $totalQty;
    						$totalAllIncrQty += $totalIncrQty;
    					?>
    					<td></td>
    					<td style="padding-top: 20px;">
    						<?php echo e(Carbon\Carbon::parse($billdata->created_at)->format('d-m-Y')); ?>

    					</td>
    					<td></td>
	    			</tr>
    		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    	
    	<tr>
			<td colspan="5">
				<div class="grandTotal" style="">
					<span>GRAND TOTAL</span>
				</div>
			</td>
			<td><?php echo e($totalAllQty); ?></td>
			<td><?php echo e($totalAllIncrQty); ?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="10">
				<p><strong>Remarks: TAKE GOODS FROM STOCK WITH <?php echo e($increase); ?>%</strong></p>
			</td>
		</tr>

		<tr>
			<td colspan="10">
				<h6>1. Quality confirm to sample card</h6>
			</td>
		</tr>

		 <tr>
		 	<td colspan="10">
		 		<h6>2. Please pack as the enclosed background and mark the styleNo. on the parcel or carton.</h6>
		 	</td>
		 </tr>
    		
    	<tr>
			<td colspan="3"><strong>PrintShop: </strong></td>
			<td colspan="2"><strong>QC: </strong></td>
			<td colspan="2"><strong>CS Superviser: </strong></td>
			<td colspan="3"><strong>CS: </strong></td>
		</tr>
	</tbody>
</table>

<script type="text/javascript">
	function myFunction() {
		$('.colspan-td table').css('font-family','arial, sans-serif');
		$('.colspan-td table').css('border-collapse','collapse');
		$('.colspan-td table').css('width','100%');
		$('.colspan-td table td').css('border','1px solid #DBDBDB');
		$('.colspan-td table td').css('padding','5px');
		$('.colspan-td table tr:first-child td').css('border-top', '0');
		$('.colspan-td table tr td:first-child').css('border-left', '0');
		$('.colspan-td table tr:last-child td').css('border-bottom', '0');
		$('.colspan-td table tr td:last-child').css('border-right', '0');
	    window.print();
	}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('maxim.layouts.layouts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>