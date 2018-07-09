@extends('layouts.dashboard')
@section('page_heading', trans("others.mxp_menu_booking_list") )
@section('section')

@section('section')
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<table class="table table-bordered table-striped ">
				<tr>
					<thead>
						<th>Serial no</th>
						<th>Buyer Name</th>
						<th>Company Name</th>
						<th>Attention</th>
						<th>booking id</th>
						<th>Order Date</th>
						<th>Shipment Date</th>
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
				</tr>
				@endforeach
			</table>

			{{$bookingList->links()}}
		</div>
	</div>
@endsection