<?php $__env->startSection('print-body'); ?>

<center>
	<a href="#" onclick="myFunction()" class="print">Print & Preview</a>
</center>



	<?php $__currentLoopData = $headerValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div class="row">
		<div class="col-md-2 col-sm-2 col-xs-2">
			<?php if($value->logo_allignment == "left"): ?>
			<?php if(!empty($value->logo)): ?>
				<div class="pull-left">
					<img src="/upload/<?php echo e($value->logo); ?>" height="100px" width="150px" />
				</div>
			<?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-8" style="padding-left: 40px;">
			<h2 align="center"><?php echo e($value->header_title); ?></h2>
			<!-- <div class="col-md-3">
				<div class="pull-left">
					FACTORY ADDRESS :
				</div>
			</div> -->

			<div align="center">
					<p>FACTORY ADDRESS :  <?php echo e($value->address1); ?> <?php echo e($value->address2); ?> <?php echo e($value->address3); ?></p>
			</div>
		</div>
		<div class="col-md-2 col-sm-2 col-xs-2">
			<?php if($value->logo_allignment == "right"): ?>
			<?php if(!empty($value->logo)): ?>
				<div class="pull-right">
					<img src="/upload/<?php echo e($value->logo); ?>" height="100px" width="150px" />
				</div>
			<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<div class="row header-bottom">
		<div class="col-md-12 header-bottom-b">
			<span>BILL COPY</span>
		</div>
	</div>

	<div class="row body-top">
		<div class="col-md-8 col-sm-8 col-xs-7 body-list">
			<?php $__currentLoopData = $buyerDatils; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Datils): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<ul>
					<li>Buyer : <?php echo e($Datils->name_buyer); ?></li>
					<li>Sold To : <?php echo e($Datils->name); ?></li>
					<li><?php echo e($Datils->address_part1_invoice); ?></li>
					<li><?php echo e($Datils->address_part2_invoice); ?></li>
					<li>Atten : <?php echo e($Datils->attention_invoice); ?></li>
					<li>Cell : <?php echo e($Datils->mobile_invoice); ?></li>
				</ul>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
		
		<div class="col-md-4 col-sm-4 col-xs-5">
			<?php ($i=0); ?>
			<?php $__currentLoopData = $sentBillId; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $billdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php for($i;$i <= 0;$i++): ?>
				<table class="tables table-bordered" style="width: 100%;">
					<tr>
						<td colspan="2">
							<div style="text-align: right;">
								<p style="padding-left :5px;"> Invo no : <?php echo e($billdata->bill_id); ?></p>
							</div>
						</td>
					</tr>
					<tr>
						<td width="50%" style="border-bottom-style:hidden;border-left-style:hidden;"> </td>
						<td width="50%">
							<div style="text-align: right;">
								<p style="padding-left :5px;"> Date : <?php echo e(Carbon\Carbon::parse($billdata->created_at)->format('Y-m-d')); ?></p>
							</div>
						</td>
					</tr>
					
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
    		$ik = 0; 		
    		$totalAllQty = 0;
    		$totalUsdAmount = 0;
    		$BDTandUSDavarage = 80;
    		$rowspanValue = 0;
    	 ?>
    	 <?php $__currentLoopData = $sentBillId; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    	 		<?php
    	 			$count = 1;
    	 			$rowspanValue += $count ; 
    	 		 ?>
    	 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    	<?php $__currentLoopData = $mainData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    		<?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

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
	    				<?php for($ik; $ik<=0; $ik++): ?>
	    				<td rowspan="<?php echo e($rowspanValue); ?>"><?php echo e($item->oss); ?></td>
	    				<?php endfor; ?>
			    		<td rowspan="<?php echo e($itemlength); ?>"><?php echo e($item->style); ?></td> 
			    		
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
			    		<td rowspan="<?php echo e($itemlength); ?>">$<?php echo e($item->unit_price); ?></td>
			    		
			    		<?php 
    						$totalAllQty += $totalQty;
    						$UsdAmount = $totalQty * $item->unit_price;

    						$totalUsdAmount += $UsdAmount;
    						$totalUsdAmount = floor($totalUsdAmount * 100) / 100;

    						$BDTandUSD = $BDTandUSDavarage * $totalUsdAmount;
    						$BDTandUSD = floor($BDTandUSD * 100) / 100;
    					?>
    					<td>$<?php echo e($UsdAmount); ?></td>
	    			</tr>
    		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    	<?php 
    		
    		// $totalAllQty = str_replace(",","",$totalAllQty);
    		// $totalUsdAmount = number_format($totalAllQty, 2, '.', '');
    		// $BDTandUSD = number_format($BDTandUSD, 2, '.', '');
    	?>
    	<tr>
			<td colspan="5"><div style="text-align: center; font-weight: bold;font-size: ;"><span>Total Qty </span></div></td>
			<td><?php echo e($totalAllQty); ?></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="7"><div style="text-align: center;font-weight: bold;font-size: ;"><span> Total Amount USD </span></div></td>
			<td>$<?php echo e($totalUsdAmount); ?></td>
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
					<?php 
						function convertNumberToWord($num = false) { 
							$num = str_replace(array(',', ' '), '' , trim($num));
							 if(! $num) {
							  return false; 
							} 
							$num = (int) $num;
							 $words = array(); 
							 $list1 = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen' );
							  $list2 = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety', 'Hundred');
							   $list3 = array('', 'Thousand', 'Million', 'Billion', 'Trillion', 'Quadrillion', 'Quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion', 'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion' );
							    $num_length = strlen($num);
							    $levels = (int) (($num_length + 2) / 3);
							    $max_length = $levels * 3; 
							    $num = substr('00' . $num, -$max_length); 
							    $num_levels = str_split($num, 3); 
							    for ($i = 0; $i < count($num_levels); $i++) 
							    	{ 
							    		$levels--; 
							    		$hundreds = (int) ($num_levels[$i] / 100); 
							    		$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : ''); 
							    		$tens = (int) ($num_levels[$i] % 100); 
							    		$singles = ''; if ( $tens < 20 ) { 
							    			$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' ); 
							    		} else { 
							    			$tens = (int)($tens / 10); $tens = ' ' . $list2[$tens] . ' '; 
							    			$singles = (int) ($num_levels[$i] % 10); 
							    			$singles = ' ' . $list1[$singles] . ' '; 
							    		} 
							    		$words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' ); 
							    	} 

						$commas = count($words); if ($commas > 1) { $commas = $commas - 1; }

						 return implode(' ', $words); }

						 $fractionUSD = explode('.', $totalUsdAmount);
						 $amountInWordUsd = convertNumberToWord($fractionUSD[0]);
						 if(sizeof($fractionUSD) > 1){
						 	$fractionInWordUSD = convertNumberToWord($fractionUSD[1]);
						 }
						 

						 $fractionBD = explode('.', $BDTandUSD);
						 $amountInWordBD = convertNumberToWord($fractionBD[0]);
						 if(sizeof($fractionBD) > 1){
						 	$fractionInWordBD = convertNumberToWord($fractionBD[1]);
						 }
					?>
					<div style="text-align:;font-weight: bold;">
						<?php if(sizeof($fractionUSD) == 1){ ?>
						<span>1. TOTAL AMOUNT : USD : <?php echo e($amountInWordUsd); ?> Only</span>
						<?php }else{?>
						<span>1. TOTAL AMOUNT : USD : <?php echo e($amountInWordUsd); ?> And <?php echo e($fractionInWordUSD); ?> Cents Only</span>
						<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div style="text-align:;font-weight: bold;">
						<?php if(sizeof($fractionBD) == 1){?>
						<span>1. TOTAL AMOUNT : BDT : <?php echo e($amountInWordBD); ?> Only</span>
						<?php }else{?>
						<span>1. TOTAL AMOUNT : BDT : <?php echo e($amountInWordBD); ?> And <?php echo e($fractionInWordBD); ?> Cents Only</span>
						<?php }?>
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
	function myFunction() {
	    window.print();
	}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('print_file.layouts.layouts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>