@extends('layouts.dashboard')
@section('page_heading', trans("others.mxp_menu_challan_list"))
@section('section')
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<table class="table table-bordered">
				<tr>
					<thead>
						<th>Serial no</th>
						<th>booking id</th>
						<th>Challan Id</th>
						<th>Create Date</th>
						<th>Action</th>
					</thead>
				</tr>
				@php($j=1)
				@foreach($challanDetails as $value)
				<tr>
					<td>{{$j++}}</td>
					<td>{{$value->checking_id}}</td>
					<td>{{$value->challan_id}}</td>
					<td>{{Carbon\Carbon::parse($value->created_at)}}</td>
					<td>
						<form action="{{Route('challan_list_action_task') }}" role="form" target="_blank">
							<input type="hidden" name="cid" value="{{$value->challan_id}}">
							<input type="hidden" name="bid" value="{{$value->checking_id}}">
							<button class="btn btn-success" target="_blank">View</button>
						</form>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
@endsection