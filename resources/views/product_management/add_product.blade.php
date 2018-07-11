@extends('layouts.dashboard')
@section('page_heading',
trans('others.add_product_label'))
@section('section')
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
		  rel="stylesheet">

<!-- Add Brand Modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="panel panel-default">
					<div class="panel-heading">{{trans('others.add_brand_label')}}
						<button type="button" class="close" data-dismiss="addBrandModal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div class="panel-body">

						{{--<form class="form-horizontal" role="form" method="POST" action="{{ Route('create_brand_action') }}">--}}
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							@if ($errors->any())
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif

							<div class="form-group">
								<label class="col-md-4 control-label">{{trans('others.brand_name_label')}}</label>
								<div class="col-md-6">
									<input type="text" class="form-control  input_required" name="brand_name" value="{{ old('brand_name')  }}">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-3 col-md-offset-4">
									<div class="select">
										<select class="form-control" type="select" name="isActive" >
											<option  value="1" name="isActive" >{{ trans("others.action_active_label") }}</option>
											<option value="0" name="isActive" >{{ trans("others.action_inactive_label") }}</option>
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button class="btn btn-primary add-product-brand" style="margin-right: 15px;">
										{{trans('others.save_button')}}
									</button>
								</div>
							</div>
						{{--</form>--}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            	@if(count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        @foreach($errors->all() as $error)
                          <li><span>{{ $error }}</span></li>
                        @endforeach
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('others.add_product_label') }}</div>
                    <div class="panel-body">                  
                        <form class="form-horizontal" action="{{ Route('add_product_action') }}" method="POST" autocomplete="off">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                            	<div class="col-sm-12 col-md-6">
                            		<div class="form-group">
		                                <label class="col-md-4 control-label">{{ trans('others.product_code_label') }}</label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control  input_required" name="p_code" value="{{old('p_code')}}" placeholder="Item code">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label class="col-md-4 control-label">{{ trans('others.product_name_label') }}</label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="p_name" value="{{old('p_name')}}" placeholder="Item Name">
		                                </div>
		                            </div>

                         

		                            <div class="form-group">
		                                <label class="col-md-4 control-label">{{ trans('others.product_description_label') }}</label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="p_description" value="{{old('p_description')}}" placeholder="Description">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label class="col-md-4 control-label">{{ trans('others.product_brand_label') }}</label>
		                               <div class="col-md-6">
										   		<div class="product-brand-list" style="width:80%; float: left;">
													<select class="form-control brand-list" name="p_brand" value="" style="width: 95% !important;">
														 <option value="{{old('p_brand')}}">{{(!empty(old('p_brand'))) ? old('p_brand') :"Choose Brand"}}</option>

														 @foreach($brands as $brand)
														 <option value="{{$brand->brand_name}}">{{$brand->brand_name}}</option>
														 @endforeach
													</select>
												</div>
											   <div class="add-brand-btn" style="width:20%; float: left; padding-top: 5px;">
												   <a  data-toggle="modal" data-target="#addBrandModal">
													   <i class="material-icons">
														   add_circle_outline
													   </i>
												   </a>
											   </div>
		                                </div>



		                            </div>

		                            <!-- <div class="form-group">
		                                <label class="col-md-4 control-label">{{ trans('others.others_color_label') }}</label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="others_color" value="{{old('others_color')}}" placeholder="Others Color">
		                                </div>
		                            </div> -->
		                            
                            	</div>

                            	<div class="col-sm-12 col-md-6">

                            		<div class="form-group">
		                                <label class="col-md-4 control-label">{{ trans('others.product_erp_code_label') }}</label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control input_required" name="p_erp_code" value="{{old('p_erp_code')}}" placeholder="ERP code">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label class="col-md-4 control-label">{{ trans('others.product_unit_price_label') }}</label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="p_unit_price" value="{{old('p_unit_price')}}" placeholder="Unit Price">
		                                </div>
		                            </div>

                            		<div class="form-group">
		                                <label class="col-md-4 control-label">{{ trans('others.product_weight_qty_label') }}</label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="p_weight_qty" value="{{old('p_weight_qty')}}" placeholder="Weight QTY">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label class="col-md-4 control-label">{{ trans('others.product_weight_amt_label') }}</label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="p_weight_amt" value="{{old('p_weight_amt')}}" placeholder="Weight AMT">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                            	<label class="col-md-4 control-label"></label>
		                                <div class="col-sm-6">
		                                    <div class="select">
		                                        <select class="form-control" type="select" name="is_active" >
		                                            <option  value="1" name="is_active" >{{ trans('others.action_active_label') }}</option>
		                                            <option value="0" name="is_active" >{{ trans('others.action_inactive_label') }}</option>
		                                        </select>
		                                    </div>
		                                </div>
		                            </div>

                            	</div>
                            </div>

                            

                            <div class="form-group">
	                            <div class="col-sm-offset-10 col-xs-offset-8">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                        {{ trans('others.save_button') }}
                                	</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(".selections").select2();
    </script>
@endsection