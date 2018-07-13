<?php $__env->startSection('title','Booking Maxim'); ?>
<?php $__env->startSection('print-body'); ?>
<?php 
	$getBuyerName = '';

	foreach($bookingReport as $details){
		$getBuyerName = $details->buyer_name;
	}
?>
	<center>
		<div class="topPreviews">
			<a href="#" onclick="myFunction()"  class="print" id="print">Print & Preview</a>
		</div>
	</center>

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding-left: 40px;">
			<?php ($i=0); ?>
			<?php $__currentLoopData = $bookingReport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php for($i;$i <= 0;$i++): ?>
					<h2 align="center"><?php echo e($details->buyer_name); ?> , ACC BOOKING</h2>
				<?php endfor; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<div align="center">
					<p>NWP - AW18 BOOKING ( JUNE )</p>
			</div>
		</div>

		<div class="col-md-12 col-xs-12">
			<?php ($k =0); ?>
			<?php $__currentLoopData = $bookingReport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php for($k;$k <= 0; $k++): ?>
				<div class="col-xs-6 col-md-6">
					<div class="pull-left">
						<p>Booking Date: <?php echo e(Carbon\Carbon::parse($details->created_at)->format('Y-m-d')); ?></p>
					</div>
				</div>
				<div class="col-xs-6 col-md-6">
					<div class="pull-right">
						<ul>
							<li>Booking No: <?php echo e($details->booking_order_id); ?></li>
							<li>Delivery Date: <?php echo e(Carbon\Carbon::parse($details->shipmentDate)->format('Y-m-d')); ?></li>
						</ul>
					</div>
				</div>
				<?php endfor; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

		</div>
	</div>

	<div class="row body-top">
		<div class="col-md-8 col-sm-8 col-xs-7 body-list">
			<ul>
				<?php $__currentLoopData = $companyInfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li>To : <?php echo e($details->header_title); ?></li>
				<li><p> <?php echo e($details->address1); ?> <?php echo e((!empty($details->address2) ? ',' : '')); ?> <?php echo e($details->address2); ?> <?php echo e((!empty($details->address3) ? ',' : '')); ?> <?php echo e($details->address3); ?></p></li>

				<li>CELL : <?php echo e($details->cell_number); ?></li>
				<li>Attn : <?php echo e($details->attention); ?></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
		
		<div class="col-md-4 col-sm-4 col-xs-5">			
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<center>
				<h4>Re : PURCHASE ORDER of ACCESSORIES against <?php echo e($getBuyerName); ?></h4>
			</center>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h4>Dear Sir's</h4>
			<p>Please issue P/I and supply the flowing goods favoring Importer's Factory as under :</p>
		</div>
	</div>

	<div class="row body-top">
		<div class="col-md-8 col-sm-8 col-xs-7 body-list">
					<?php ($i=0); ?>
					<?php $__currentLoopData = $bookingReport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php for($i;$i <= 0;$i++): ?>
						<ul>
							<li style="font-weight: bold;">Buyer : <?php echo e($details->buyer_name); ?></li>
						</ul>
					<?php endfor; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
		
		<div class="col-md-4 col-sm-4 col-xs-5">			
		</div>
	</div>

    <?php $__currentLoopData = $bookingReport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<table class="table table-bordered">
	        <?php
	        	
	        	$gmtsColor = [];
	        	$gmtsItemSize = [];
	        	$gmtsquantity = '';
	        	$gmtsItemQtyValue = [];
	        	foreach ($gmtsOrSizeGroup as $gmtsValue) {
	        		$gmtsColor[] = $gmtsValue->gmts_color;
	        		$gmtsItemSize = explode(',', $gmtsValue->itemSize);
	        		$gmtsquantity = explode(',', $gmtsValue->quantity);
	        		$gmtsItemQtyValue[] = array_combine($gmtsItemSize, $gmtsquantity);
	        	}
	        	$count = count($gmtsColor) - 1;
	        	$gmtscolorAllValues = array();
	        	for ($i=0; $i <= $count ; $i++) { 
	        		$gmtscolorAllValues[$i][] =$gmtsColor[$i];
	        		$gmtscolorAllValues[$i][] =$gmtsItemQtyValue[$i];
	        	}

	        	
	        	$itemsize = explode(',', $details->itemSize);
	        	$qty = explode(',', $details->quantity);
	        	$itemQtyValue = array_combine($itemsize, $qty);

	        	$itemName = [];
	        	foreach ($itemQtyValue as $key => $value) {
	        		$itemName[$key] = $key;
	        	}

	        	// colspan count values

	        	$array1 =[
	        		'0' => 's','1' => 'S','2' => 'm','3' => 'M','4' => 'xl','5' => 'XL',
	        		'6' => 'xxl','7' => 'XXL','8' => '4xl','9' => '4XL','10' => '5xl',
	        		'11' => '5XL'
	        	];
	        	$countValue = array_intersect($array1, $itemName);
	        	$colspanValue = 2 + count($countValue);


	        	// print_r("<pre>");
	        	// print_r($colspanValue);

	        ?>


	        <!-- table head section -->

		    <thead>
		        <tr>
		        	<th width="18%">ITEM / CODE NO</th>

		        	<?php if(!empty($details->gmtsColor)): ?>
		        		<th width="22%">GMTS COLOR</th>
		        	<?php endif; ?>

		        	<?php ($s = 0); ?>
		        		<?php for($s;$s<=0;$s++): ?>
		        			<?php if(
		        			'S' === array_search('S',$itemName) || 
		        			's' === array_search('s',$itemName) ||
		        			'M' === array_search('M',$itemName) || 
		        			'm' === array_search('m',$itemName) ||
		        			'xl' === array_search('xl',$itemName) || 
		        			'XL' === array_search('XL',$itemName) ||
		        			'xxl' === array_search('xxl',$itemName) || 
		        			'XXL' === array_search('XXL',$itemName) ||
		        			'4xl' === array_search('4xl',$itemName) || 
		        			'4XL' === array_search('4XL',$itemName) ||
		        			'5xl' === array_search('5xl',$itemName) || 
		        			'5XL' === array_search('5XL',$itemName)
		        			): ?>
		        				<?php $__currentLoopData = $itemQtyValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys =>$itemFormat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			        				<?php if(sizeof($itemQtyValue) === 1): ?>
			        					<th width=""><?php echo e($keys); ?></th>
			        				<?php else: ?>
						        		<th><?php echo e($keys); ?></th>
						        	<?php endif; ?>
					        	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

					        <?php elseif(empty($details->others_color)): ?>
		        				<th width="45%">Size</th>
		        			<?php elseif($details->others_color): ?>
		        				<th><?php echo e($details->others_color); ?></th>
		        			<?php else: ?>
		        				<th>Something Wrong</th>
		        			<?php endif; ?>
		        		<?php endfor; ?>    		  

		        	<th width="21%">ORDER QTY</th>

		        	<th>UNIT</th>

		        </tr>
		    </thead>

		    <!-- End table head section -->

		    <!-- table tbody Section -->

		    <tbody>
		    	<td width="18%"><?php echo e($details->item_code); ?></td>

		    	<?php if(!empty($details->gmtsColor)): ?>
		    		<?php if(
		    			'S' === array_search('S',$itemName) || 
				        's' === array_search('s',$itemName) ||
		    			'M' === array_search('M',$itemName) || 
		    			'm' === array_search('m',$itemName) ||
		    			'xl' === array_search('xl',$itemName) || 
		    			'XL' === array_search('XL',$itemName) ||
		    			'xxl' === array_search('xxl',$itemName) || 
		    			'XXL' === array_search('XXL',$itemName) ||
		    			'4xl' === array_search('4xl',$itemName) || 
		    			'4XL' === array_search('4XL',$itemName) ||
		    			'5xl' === array_search('5xl',$itemName) || 
		    			'5XL' === array_search('5XL',$itemName)
		    		): ?>
			    		<td class="colspan-td" colspan="<?php echo e($colspanValue); ?>">
			    			<table>
			    				<?php $__currentLoopData = $gmtscolorAllValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			    					<?php $__currentLoopData = $values[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $aaa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			    					<?php $totalQnty = 0; $gmtscolorAllValuesKeys = [];$gmtscolorAllValuesKeys[$keys] = $keys; ?>
					    			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				    					<?php if(
							    			'S' === array_search('S',$gmtscolorAllValuesKeys) || 
									        's' === array_search('s',$gmtscolorAllValuesKeys) ||
							    			'M' === array_search('M',$gmtscolorAllValuesKeys) || 
							    			'm' === array_search('m',$gmtscolorAllValuesKeys) ||
							    			'xl' === array_search('xl',$gmtscolorAllValuesKeys) || 
							    			'XL' === array_search('XL',$gmtscolorAllValuesKeys) ||
							    			'xxl' === array_search('xxl',$gmtscolorAllValuesKeys) || 
							    			'XXL' === array_search('XXL',$gmtscolorAllValuesKeys) ||
							    			'4xl' === array_search('4xl',$gmtscolorAllValuesKeys) || 
							    			'4XL' === array_search('4XL',$gmtscolorAllValuesKeys) ||
							    			'5xl' === array_search('5xl',$gmtscolorAllValuesKeys) || 
							    			'5XL' === array_search('5XL',$gmtscolorAllValuesKeys)
							    		): ?>
					    					<tr>
						    					<?php if(!empty($values[0])): ?>
							    					<td width="30%"><?php echo e($values[0]); ?></td>
							    				<?php endif; ?>

							    				<?php if(!empty($values[1])): ?>
							    					<?php $__currentLoopData = $values[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyss => $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							    					<?php 
							    						$totalQnty = $totalQnty + $values;
							    					?>
							    						<td><?php echo e($values); ?></td>
							    					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							    				<?php endif; ?>

							    				<td width="29%"><?php echo e($totalQnty); ?></td>
							    			</tr>
							    		<?php else: ?>
							    		<?php endif; ?>
					    		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			    			</table>
			    		</td>
		    		<?php else: ?>
				    	<td class="colspan-td" colspan="3">
			    			<table>
			    				<tbody>		    					
			    					<?php $__currentLoopData = $gmtscolorAllValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			    						<?php $__currentLoopData = $values[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $aaa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				    					<?php $gmtscolorAllValuesKeys = [];$gmtscolorAllValuesKeys[$keys] = $keys; ?>
						    			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						    			
					    					<?php if(
								    			'S' === array_search('S',$gmtscolorAllValuesKeys) || 
										        's' === array_search('s',$gmtscolorAllValuesKeys) ||
								    			'M' === array_search('M',$gmtscolorAllValuesKeys) || 
								    			'm' === array_search('m',$gmtscolorAllValuesKeys) ||
								    			'xl' === array_search('xl',$gmtscolorAllValuesKeys) || 
								    			'XL' === array_search('XL',$gmtscolorAllValuesKeys) ||
								    			'xxl' === array_search('xxl',$gmtscolorAllValuesKeys) || 
								    			'XXL' === array_search('XXL',$gmtscolorAllValuesKeys) ||
								    			'4xl' === array_search('4xl',$gmtscolorAllValuesKeys) || 
								    			'4XL' === array_search('4XL',$gmtscolorAllValuesKeys) ||
								    			'5xl' === array_search('5xl',$gmtscolorAllValuesKeys) || 
								    			'5XL' === array_search('5XL',$gmtscolorAllValuesKeys)
								    		): ?>
								    		<?php else: ?>
						    					<tr>
						    						<?php if(!empty($values[0])): ?>
							    					<td width="30.7%"><?php echo e($values[0]); ?></td>
							    					<td width="69.3%" colspan="2">
							    					 	<?php $__currentLoopData = $values[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size => $qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							    					 	<div class="middel-table">
								    					 	<table>
								    					 		<tr>
								    					 			<td width="57.5%"><?php echo e($size); ?></td>
								    					 			<td width="42.5%"><?php echo e($qty); ?></td>
								    					 		</tr>
								    					 	</table>
								    					</div>	
							    					 	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							    					</td>
							    					<?php endif; ?>
						    					</tr>
						    				<?php endif; ?>
			    					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			    				</tbody>
			    			</table>		    		
			    		</td>		    		
		        	<?php endif; ?>
		        <?php endif; ?>
		        
		        <?php if(
		        'S' === array_search('S',$itemName) || 
		        's' === array_search('s',$itemName) ||
    			'M' === array_search('M',$itemName) || 
    			'm' === array_search('m',$itemName) ||
    			'xl' === array_search('xl',$itemName) || 
    			'XL' === array_search('XL',$itemName) ||
    			'xxl' === array_search('xxl',$itemName) || 
    			'XXL' === array_search('XXL',$itemName) ||
    			'4xl' === array_search('4xl',$itemName) || 
    			'4XL' === array_search('4XL',$itemName) ||
    			'5xl' === array_search('5xl',$itemName) || 
    			'5XL' === array_search('5XL',$itemName)
    			): ?>			   				

		        <?php elseif(empty($details->others_color)): ?>
		        	<td class="colspan-td" colspan="2">
		        		<table>
		        			<?php $__currentLoopData = $itemQtyValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sizeValue => $qtyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		        				<tr>
		        					<td width="68.7%"><?php echo e($sizeValue); ?></td>
	    							<td width="37.3%"><?php echo e($qtyValue); ?></td>
		        				</tr>
		        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		        		</table>
		        	</td>
    			<?php else: ?>
    			<?php endif; ?>
    			
		        <td>PCS</td>
		    </tbody>

		    <!-- End table tbody Section -->
		</table>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


	<script type="text/javascript">
		function myFunction() {
			$(".print").addClass("hidden");
		    window.print();
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('maxim.layouts.layouts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>