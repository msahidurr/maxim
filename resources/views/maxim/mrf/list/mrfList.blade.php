@extends('layouts.dashboard')
@section('page_heading', trans("others.mxp_menu_mrf_list") )
@section('section')

@section('section')
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<table class="table table-bordered">
				<tr>
					<thead>
						<th>Serial no</th>
						<th>booking id</th>
						<th>MRF Id</th>
						<th>MRF Create Date</th>
						<th>MRF Shipment Date</th>
						<th>Action</th>
					</thead>
				</tr>
				@php($j=1)
				@foreach($bookingList as $value)
				<tr>
					<td>{{$j++}}</td>
					<td>{{$value->booking_order_id}}</td>
					<td>{{$value->mrf_id}}</td>
					<td>{{Carbon\Carbon::parse($value->created_at)}}</td>
					<td>{{$value->shipmentDate}}</td>
					<td>
						<form action="{{Route('mrf_list_action_task') }}" role="form" target="_blank">
							<input type="hidden" name="mid" value="{{$value->mrf_id}}">
							<input type="hidden" name="bid" value="{{$value->booking_order_id}}">
							<button class="btn btn-success" target="_blank">View</button>
						</form>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
@endsection