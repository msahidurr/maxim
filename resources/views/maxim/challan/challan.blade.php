@extends('layouts.dashboard')
@section('page_heading', trans("others.mxp_menu_challan_boxing_list") )
@section('section')

@section('section')
    <div class="container-fluid">
    	@if(Session::has('erro_challan'))
            @include('widgets.alert', array('class'=>'danger', 'message'=> Session::get('erro_challan') ))
		@endif
		<div class="row">
			<div class="col-md-12 col-md-offset-0">
				<div class="panel panel-default">
					<div class="panel-heading">{{trans('others.mxp_menu_challan_boxing_list')}}</div>
					<div class="panel-body">
							@if(!empty($bookingDetails))							
							<!-- <div class="col-md-12"> -->
								<!-- <span style="font-size:15px;padding-bottom: 15px;">Challan data for edit</span> -->
								<form class="form-horizontal" role="form" method="POST" action="{{ Route('multiple_challan_action_task') }}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">

									<table class="table table-bordered table-striped" >
										<thead>
											<tr>
												<th>SerialNo</th>
												<th width="">ERP Code</th>
												<th width="">Item Code</th>
												<th width="">Item Size</th>
												<th width="">Item Quantity</th>
											</tr>
										</thead>
										<?php
										   $i=1;
										 ?>
										@foreach ($bookingDetails as $item)
											<?php
							    				$itemsize = explode(',', $item->itemSize);  				
							    				$qty = explode(',', $item->quantity);
							    				$itemQtyValue = array_combine($itemsize, $qty);
							    			?>
										<tbody>
											<tr>
												<td>{{$i++}}</td>
												<td>{{$item->erp_code}}</td>
												<td>{{$item->item_code}}</td>
												<td colspan="2" class="colspan-td">
								    				<table width="100%" id="sampleTbl">
								    					@foreach ($itemQtyValue as $size => $Qty)
								    					@if(empty($size))
								    					<tr>
								    						<td width="50%"></td>
											    			<td width="50%" class="aaa">
											    				<input type="hidden" name="allId[]" value="{{$item->id}}">
																<input type="text" class="form-control item_quantity" name="product_qty[]" value="{{$Qty}}">
											    			</td>
											    		</tr>
								    					@else
								    					<tr>
								    						<td width="50%">
								    							{{$size}}
								    						</td>
											    			<td width="50%" class="aaa">
								    							<input type="hidden" name="allId[]" value="{{$item->id}}">
								    							<div class="question_div">
																<input type="text" class="form-control item_quantity" name="product_qty[]" value="{{$Qty}}">
											    				</div>

											    			</td>
								    					</tr>
								    					@endif
								    					@endforeach
								    				</table>
								    			</td>
												
											</tr>
											
										</tbody>
										@endforeach
									</table>
								

									<div class="form-group ">
										<div class="col-md-6 col-md-offset-10">
											<button type="submit" class="btn btn-primary" id="rbutton">
												{{trans('others.genarate_bill_button')}}
											</button>
										</div>
									</div>
								</form>
							<!-- </div> -->

							@if(!empty($multipleChallanList))
								<span style="font-size:15px;">Multiple Challan list</span>
								<table class="table table-bordered">
									<thead>
										<th>Serial No</th>
										<th>Invo no</th>
										<th>Challan no</th>
									</thead>
									@php($k = 1)
									@foreach($multipleChallanList as $ChallanList)
										<tr>
											<td>{{$k++}}</td>
											<td>{{$ChallanList->bill_id}}</td>
											<td>{{$ChallanList->challan_id}}</td>	
										</tr>
									@endforeach
								</table>
							@endif
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection