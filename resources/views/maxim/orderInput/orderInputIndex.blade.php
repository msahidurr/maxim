@extends('layouts.dashboard')

@section('page_heading',$taskType
)

<!-- trans('others.mxp_menu_bill_copy') -->
@section('section')
	<style type="text/css">
		.top-div{
			background-color: #f9f9f9; 
			padding:5px 0px 5px 10px; 
			border-radius: 7px;
		}
	</style>

	<div class="col-md-12">
		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		               <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		@if(Session::has('error_code'))
	    	@include('widgets.alert', array('class'=>'danger', 'message'=> Session::get('error_code') ))
		@endif

			<form class="" action="{{ Route('booking_order_action') }}" role="form" method="POST" >
	            <input type="hidden" name="_token" value="{{ csrf_token() }}">
	            
	            <input type="hidden" name="buyerDetails" value="{{$buyerDetails}}">

	            <div class="top-div">
	            	<?php
	            		$buyerName = '';
	            	    $CompanyName = '';

	            	  ?>
	            	@foreach ($buyerDetails as $buyer)
	            		<?php
                            $buyerName = $buyer->name_buyer;
                            $CompanyName = $buyer->name;
	            		?>
	            	@endforeach
	            	<div class="row">
		        		<div class="col-md-6 col-xs-6">
		        			<div class="form-group">
		        				<label class="col-md-4">Buyer name</label>

		        				<div class="">
		        					<input type="text" name="buyerName" class="form-control" readonly="true" value="{{$buyerName}}" title="Buyer Name">
		        				</div>
		        			</div>            			
		        		</div>

		        		<div class="col-md-6 col-xs-6">
		        			<div class="form-group " >
		        				<label class="col-md-4">Company name</label>

		        				<div class="" >
		        					<input type="text" name="CompanyName" class="form-control" readonly="true" value="{{$CompanyName}}" title="Company Name">
		        				</div>
		        			</div>
		        		</div>
	        		</div>
	        		<div style="padding-top: 10px;"></div>
		            <table class="table-striped" width="100%">
		            	<thead>
		            		<tr>
		            			<td>Order Date</td>
		            			<td>OS</td>
		            			<td>Shipment Date</td>
		            			<td>PO/Cat NO</td>
		            		</tr>
		            	</thead>
						<tbody>
							<tr>
								<td>
									<div class="form-group">
										<input type="Date" name="orderDate" class="form-control" placeholder="Order Date" title="Order Date">
									</div>
								</td>

								<td>
									<div class="form-group">
										<input type="text" name="orderNo" class="form-control" placeholder="OS" title="OS No">
									</div>
								</td>

								<td>
									<div class="form-group">
										<input type="date" name="shipmentDate" class="form-control" placeholder="Shipment Date" title="Shipment Date" required>
									</div>
								</td>

								<td>
									<div class="form-group">
										<input type="text" name="poCatNo" class="form-control" placeholder="PO Cat No" title ="PO Cat No">
									</div>
								</td>
							</tr>
						</tbody>
					</table>					
	            </div>


				<div style="padding-top: 20px;"></div>

				<table class="table-striped" id="filed_increment">
					<thead>
						<tr>							
							<th width="15%">Item Code</th>
							<th>ERP Code</th>
							<th>GMTS Color</th>
							<th>Item Size</th>
							<th>Item Qty</th>
							<th>Item price</th>
							<th></th>
						</tr>
					</thead>
					<tbody class="idclone" >
						<tr class="tr_clone">
								<input type="hidden" name="others_color[]" class="others_color" id="others_color" value="">
								<input type="hidden" name="item_description[]" class="item_description" id="item_description" value="">

							<td width="15%">
								<div class="form-group abcde">
									<input type="text" name="item_code[]" class="form-control item_code" id="item_code">
								</div>
							</td>
							<td width="20%">
								<div class="form-group">
									<select name="erp[]" class="form-control erpNo" id="erpNo" readonly = "true">
									</select>
								</div>
							</td>
							
							<td width="20%">
								<div class="form-group">
									<select name="item_gmts_color[]" class="form-control itemGmtsColor" id="itemGmtsColor" readonly="true"></select>
								</div>
							</td>

							<td width="20%">
								<div class="form-group">
									<!-- <input type="text" name="item_size[]" class="form-control"> -->

									<select name="item_size[]" class="form-control itemSize" id="itemSize" disabled = "true" >
									</select>
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="text" name="item_qty[]" class="form-control item_qty">
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="text" name="item_price[]" class="form-control item_price" >  
									<!-- readonly -->
								</div>
							</td>
							<td></td>
						</tr>
					</tbody>		
				</table>
				<!-- <div class="row">
					<div class="col-md-6 col-xs-6"></div>
					<div class="col-md-6 col-xs-6">
						<div class="pull-right"> -->
							<div class="form-group button_add">
								<button type="submit" class="btn btn-success" id="add"><i class="fa fa-plus" style="padding-right: 5px;"></i>Add Filed</button>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Genarate</button>
							</div>
						<!-- </div>
					</div>
				</div> -->
				
			</form>

	</div>
@endsection