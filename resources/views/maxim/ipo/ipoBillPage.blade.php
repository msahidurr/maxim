@extends('maxim.layouts.layouts')
@section('print-body')
<center>
	<a href="#" onclick="myFunction()" class="print">Print & Preview</a>
</center>


	@foreach($buyerDetails as $details)
		<div class="row">
			<div class="col-md-2">
				
			</div>
			<div class="col-md-8" style="padding-left: 40px;">
				<h2 align="center">{{$details->buyer_name}}</h2>
			</div>
			<div class="col-md-2"></div>
		</div>
	@endforeach
	<div class="row header-bottom">
		<div class="col-md-12 header-bottom-b">
			<span>Internal Purchase Order</span>
		</div>
		<hr>
	</div>

	<div class="row body-top">
		<div class="col-md-6 col-xs-7 body-list">
			@foreach($buyerDetails as $details)
				<ul>
					<li><strong>Booking ID: {{$details->booking_order_id}}</strong></li>
					<li><strong>Company Name: {{$details->buyer_name}}</strong></li>
					<li><h5>Date : {{Carbon\Carbon::now()->format('Y-m-d')}}</h5></li>
				</ul>
			@endforeach
		</div>
		
		<div class="col-md-6 col-xs-5">
			@php ($i=0)
			@foreach ($sentBillId as $billdata)
				@for($i;$i <= 0;$i++)
				<table class="tables table-bordered" style="width: 100%;">
					<tr >
						<td colspan="2">
							<div style="text-align: right;">
								<p style="padding-left :5px;"><strong>MAY PORTION</strong></p>
							</div>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<div style="text-align: right;">
								<p style="padding-left :5px;">Checking No : {{$billdata->ipo_id}}</p>
							</div>
						</td>
					</tr>
				</table>
			@endfor
			@endforeach
			
		</div>
	</div>
<?php 
	if($initIncrease == ''){
		$increase = 2;
	}else{
		$increase = $initIncrease;
	}
?>
<table class="table table-bordered">
	      
    <thead>
    	<tr>
        	<th width="5%">SI</th>
        	<th width="10%">PO/CAT</th>
        	<th width="10%">Item code</th>
        	<th width="15%">Description</th>
        	<th width="10%">TOTAL PCS/MTR</th>
        	<th width="10%">{{$increase}}%</th>
        	<th width="10%">1ST DELIVERY</th>
            <th width="10%">Request Date</th>
            <th width="10%">Confirmation Date</th>
            <th width="10%">Supllier</th>
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
    	 	@foreach($sentBillId as $counts)
    	 		<?php
    	 			$count = 1;
    	 			$rowspanValue += $count;
    	 		 ?>
    	 	@endforeach

    		@foreach ($sentBillId as $key => $item)

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
	    				<td>{{$j++}}</td>
	    				<td rowspan="{{$itemlength}}">{{$item->poCatNo}}</td>
	    				<td rowspan="{{$itemlength}}">{{$item->item_code}}</td>
	    				<td rowspan="{{$itemlength}}">{{$item->erp_code}}</td>			    		
			    			@if ($itemlength >= 1 )
				    			<td colspan="1" class="colspan-td">  				
				    				<table>
				    					@foreach ($itemQtyValue as $size => $Qty)
				    					<?php 
				    						$i++;
				    						$totalQty += $Qty; 
				    					?>
				    					<tr>
				    						<!-- <td width="50%">{{$size}}</td> -->
							    			<td width="50%">{{$Qty}}</td>
				    					</tr>
				    					@endforeach

				    					@if( $i > 1 )
				    					<tr>
				    						<td width="100%">{{$i}}{{$totalQty}}</td>
				    					</tr>
				    					@endif
				    				</table>
				    			</td>
				    			<td colspan="1" class="colspan-td">  				
				    				<table>
				    					@foreach ($itemQtyValue as $size => $Qty)
				    					<?php 
				    						$k++;
				    						$totalIncrQty += ceil(($Qty*$increase)/100 + $Qty); 
				    					?>
				    					<tr>

							    			<td width="100%">{{ceil(($Qty*$increase)/100 + $Qty)}}</td>
				    					</tr>
				    					@endforeach

				    					@if( $k > 1 )
				    					<tr>
				    						<td width="100%">{{$totalIncrQty}}</td>
				    					</tr>
				    					@endif
				    				</table>
				    			</td>
				    		@endif			    		   
			    		<?php 
    						$totalAllQty += $totalQty;
    						$totalAllIncrQty += $totalIncrQty;
    					?>
    					<td></td>
    					<td style="padding-top: 20px;">
    						{{Carbon\Carbon::parse($billdata->created_at)->format('d-m-Y')}}
    					</td>
    					<td></td>
    					<td></td>
	    			</tr>
    		@endforeach
    	
    	<tr>
			<td colspan="4"><div style="text-align: center; font-weight: bold;font-size: ;"><span>GRAND TOTAL</span></div></td>
			<td>{{$totalAllQty}}</td>
			<td>{{$totalAllIncrQty}}</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="10">
				<p><strong>Remarks: TAKE GOODS FROM STOCK WITH {{$increase}}%</strong></p>
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
	    window.print();
	}
</script>
@endsection
