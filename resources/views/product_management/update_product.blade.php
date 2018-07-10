@extends('layouts.dashboard')
@section('page_heading',
trans('others.update_product_label'))
@section('section')
<div class="container-fluid">
        <div class="row">
             <div class="col-md-12 ">   <!--col-md-offset-2 -->
            	@if(count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        @foreach($errors->all() as $error)
                          <li><span>{{ $error }}</span></li>
                        @endforeach
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('others.update_product_label') }}</div>
                    <div class="panel-body">
                        @foreach($product as $data)
                
                        <form class="form-horizontal" action="{{ Route('update_product_action') }}/{{$data->product_id}}" method="POST" autocomplete="off">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ trans('others.product_code_label') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control  input_required" name="p_code" value="{{$data->product_code}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ trans('others.product_name_label') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="p_name" value="{{$data->product_name}}">
                                        </div>
                                    </div>                         

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ trans('others.product_description_label') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="p_description" value="{{$data->product_description}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ trans('others.product_brand_label') }}</label>
                                       <div class="col-md-6">
                                            <select class="form-control " name="p_brand" required value="">                   
                                                 <option value="{{$data->brand}}">{{$data->brand}}</option>
                                                 @foreach($brands as $brand)
                                                 <option value="{{$brand->brand_name}}">{{$brand->brand_name}}</option>
                                                 @endforeach 
                                            </select>
                                        </div>
                                    </div>                                    

                                    <!-- <div class="form-group">
                                        <label class="col-md-4 control-label">{{ trans('others.others_color_label') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="others_color" value="{{$data->others_color}}">
                                        </div>
                                    </div> -->

                                </div>


                                <div class="col-md-6 col-sm-12">

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ trans('others.product_erp_code_label') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control  input_required" name="p_erp_code" value="{{$data->erp_code}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ trans('others.product_unit_price_label') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="p_unit_price" value="{{ $data->unit_price}}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ trans('others.product_weight_qty_label') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="p_weight_qty" value="{{$data->weight_qty}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ trans('others.product_weight_amt_label') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="p_weight_amt" value="{{$data->weight_amt}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4"></label>
                                        <div class="col-md-6">
                                            <div class="select">
                                                <select class="form-control" type="select" name="is_active" >
                                                    <option value="{{$data->status}}">
                                                        {{($data->status == 1) ? "Active" : "Inactive"}}
                                                    </option>
                                                    <option  value="1" name="is_active" >{{ trans('others.action_active_label') }}</option>
                                                    <option value="0" name="is_active" >{{ trans('others.action_inactive_label') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
	                            <div class="col-md-offset-10">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                        {{ trans('others.update_button') }}
                                	</button>
                                </div>
                            </div>
                        </form>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(".selections").select2();
    </script>
@endsection