@extends('print_file.layouts.layouts')
@section('print-body')

	<center>
		<div class="topPreviews">
			<a href="#" onclick="myFunction()"  class="print" id="print">Print & Preview</a>
		</div>
	</center>

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding-left: 40px;">
			@php($i=0)
			@foreach($bookingReport as $details)
				@for($i;$i <= 0;$i++)
					<h2 align="center">{{$details->buyer_name}} , ACC BOOKING</h2>
				@endfor
			@endforeach
			<div align="center">
					<p>NWP - AW18 BOOKING ( JUNE )</p>
			</div>
		</div>

		<div class="col-md-12 col-xs-12">
			<div class="col-xs-6 col-md-6">
				<div class="pull-left">
					<p>Booking Date: 08-07-18</p>
				</div>
			</div>
			<div class="col-xs-6 col-md-6">
				<div class="pull-right">
					<p>Delivery Date: 20-07-18</p>
				</div>
			</div>
		</div>
	</div>

	<div class="row body-top">
		<div class="col-md-8 col-sm-8 col-xs-7 body-list">
			<ul>
				@foreach ($companyInfo as $details)
				<li>To : {{$details->header_title}}</li>
				<li><p> {{$details->address1}} {{(!empty($details->address2) ? ',' : '')}} {{$details->address2}} {{(!empty($details->address3) ? ',' : '')}} {{$details->address3}}</p></li>

				<li>CELL : {{$details->cell_number}}</li>
				<li>Attn : {{$details->attention}}</li>
				@endforeach
			</ul>
		</div>
		
		<div class="col-md-4 col-sm-4 col-xs-5">			
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<center>
				<h4>Re : PURCHASE ORDER of ACCESSORIES against REGATTA (AW18)</h4>
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
					@php($i=0)
					@foreach($bookingReport as $details)
					@for($i;$i <= 0;$i++)
						<ul>
							<li style="font-weight: bold;">Buyer : {{$details->buyer_name}}</li>
						</ul>
					@endfor
					@endforeach
		</div>
		
		<div class="col-md-4 col-sm-4 col-xs-5">			
		</div>
	</div>


    @foreach ($bookingReport as $details)
		<table class="table table-bordered">
	        <?php
	        	$itemsize = explode(',', $details->itemSize);
	        	$qty = explode(',', $details->quantity);

	        	$gmtsColor = '';
	        	$gmtsItemSize = [];
	        	$gmtsquantity = [];
	        	$gmtsItemQtyValue = [];
	        	foreach ($gmtsOrSizeGroup as $gmtsValue) {
	        		$gmtsColor = $gmtsValue->gmts_color;
	        		$gmtsItemSize[] = explode(',', $gmtsValue->itemSize);
	        		$gmtsquantity[] = explode(',', $gmtsValue->quantity);
	        	}
	        	$gmtsItemQtyValue = array_combine($itemsize, $qty);

	        	$itemQtyValue = array_combine($itemsize, $qty);
	        	$itemName = [];
	        	foreach ($gmtsItemQtyValue as $key => $value) {
	        		$itemName[$key] = $key;
	        	}
	        ?>

		    <thead>
		        <tr>
		        	<th width="18%">ITEM / CODE NO</th>

		        	@if(!empty($details->gmtsColor))
		        		<th>GMTS COLOR</th>
		        	@endif

	        		@for($s = 0;$s <= 0;$s++)

	        			@if(
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
	        			)
	        				@foreach ($itemQtyValue as $keys =>$itemFormat)
				        		<th>{{$keys}}</th>
				        	@endforeach

				        @elseif (empty($details->others_color))
	        				<th>Size</th>
	        			@elseif ($details->others_color)
	        				<th>{{$details->others_color}}</th>
	        			@else
	        				<th>Something Wrong</th>
	        			@endif
	        		@endfor    		  

		        	<th>ORDER QTY</th>

		        	<th>UNIT</th>

		        </tr>
		    </thead>



		    <tbody>
		    	<td width="18%">{{$details->item_code}}</td>

		    	@if(!empty($details->gmtsColor))
			    	<td class="colspan-td">
		    			<table>
		    				<tbody>
		    					@foreach ($gmtsOrSizeGroup as $gmtsValue)
		    						@if (empty($gmtsValue->gmts_color))
		    						@else
				    					<tr>
				    						<td rowspan=""> {{$gmtsValue->gmts_color}}</td>
				    					</tr>
			    					@endif
		    					@endforeach
		    				</tbody>
		    			</table>		    		
		    		</td>
		        @endif
		        
		        @if(
		        'S'   === array_search('S',$itemName) || 
		        's'   === array_search('s',$itemName) ||
    			'M'   === array_search('M',$itemName) || 
    			'm'   === array_search('m',$itemName) ||
    			'xl'  === array_search('xl',$itemName) || 
    			'XL'  === array_search('XL',$itemName) ||
    			'xxl' === array_search('xxl',$itemName) || 
    			'XXL' === array_search('XXL',$itemName) ||
    			'4xl' === array_search('4xl',$itemName) || 
    			'4XL' === array_search('4XL',$itemName) ||
    			'5xl' === array_search('5xl',$itemName) || 
    			'5XL' === array_search('5XL',$itemName)
    			)
    				<td class="colspan-td" colspan="{{count($gmtsquantity)}}">
    					<table>
    						<tbody>
    							<tr>    							
	    							@foreach ($gmtsquantity as $qtyValue)
		    							
				        					<td>{{$qtyValue}}</td>	
		    									        				
			        				@endforeach	
		        				</tr>	        				
    						</tbody>
    					</table>
    					
    				</td>    				

		        @elseif (empty($details->others_color))
		        	<td class="colspan-td">
		        		<table>
		        			@foreach ($itemsize as $sizeValue)
		        				<tr>
		        					<td>{{$sizeValue}}</td>
		        				</tr>
		        			@endforeach
		        		</table>
		        	</td>
    			@elseif ($details->others_color)  <!-- jothi others color thake  -->
    				<td class="colspan-td">
    					<table>
    						<tbody>
    							@foreach ($itemsize as $sizeValue)
	    							<tr>
	    								<td>{{$sizeValue}}</td>
	    							</tr>
    							@endforeach
    						</tbody>
    					</table>
    				</td>
    			@else
    				<td>Something Wrong</td>
    			@endif

    			<!-- this is qnty section -->
    			@if(
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
    			)
    			<td>44444444</td>

    			@elseif (empty($details->others_color))
    				<td class="colspan-td">
    					<table>
    						<tbody>
	    						@foreach ($qty as $keys => $sizeValue)
	    							<tr>
	    								<td>{{$sizeValue}}</td>
	    							</tr>
	    						@endforeach
    						</tbody>
    					</table>
    				</td>
    			@elseif ($details->others_color)  <!-- jothi others color thake  -->
    				<td class="colspan-td">
    					<table>
    						<tbody>
    							@foreach ($qty as $keys => $sizeValue)
	    							<tr>
	    								<td>{{$sizeValue}}</td>
	    							</tr>
    							@endforeach
    						</tbody>
    					</table>
    				</td>
    			@else
    				<td>qty</td>
    			@endif
		        <td>PCS</td>
		    </tbody>
		</table>
    @endforeach

	<script type="text/javascript">
		function myFunction() {
			$(".print").addClass("hidden");
		    window.print();
		}
	</script>
@endsection
