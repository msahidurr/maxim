@extends('layouts.dashboard')
@section('page_heading', trans("others.mxp_menu_booking_list") )
@section('section')

@section('section')
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<table class="table table-bordered">
				<tr>
					<thead>
						<th>Serial no</th>
						<th>Buyer Name</th>
						<th>Company Name</th>
						<th>Attention</th>
						<th>booking id</th>
						<th>Order Date</th>
						<th>Shipment Date</th>
						<th>Action</th>
					</thead>
				</tr>
				@php($j=1)
				@foreach($bookingList as $value)
				<tr>
					<td>{{$j++}}</td>
					<td>{{$value->buyer_name}}</td>
					<td>{{$value->Company_name}}</td>
					<td>{{$value->attention_invoice}}</td>
					<td>{{$value->booking_order_id}}</td>
					<td>{{Carbon\Carbon::parse($value->created_at)}}</td>
					<td></td>
					<td>
						<form action="{{ Route('booking_list_action_task') }}" target="_blank">
							<input type="hidden" name="bid" value="{{$value->booking_order_id}}">
							<button class="btn btn-success">View</button>
						</form>
					</td>
				</tr>
				@endforeach
			</table>

			{{$bookingList->links()}}
		</div>
	</div>
@endsection