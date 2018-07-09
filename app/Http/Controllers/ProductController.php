<?php

namespace App\Http\Controllers;

use App\Http\Controllers\dataget\ListGetController;
use App\Http\Controllers\Message\StatusMessage;
use App\Http\Controllers\RoleManagement;
use App\MxpProduct;
use App\MxpBrand;
use Auth;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    const CREATE_PRODUCT = "create";
    const UPDATE_PRODUCT = "update";
	const ACTIVE_BRAND = 1;

    Public function productList(){
    	$products = MxpProduct::where('user_id',Auth::user()->user_id)->paginate(20);
    	return view('product_management.product_list',compact('products'));
    }

    Public function addProductListView(){

        $brands = MxpBrand::where([['user_id',Auth::user()->user_id],['status', self::ACTIVE_BRAND]])->get();
    	return view('product_management.add_product',compact('brands'));
    }
    Public function updateProductView(Request $request){
        $brands = MxpBrand::where('status', self::ACTIVE_BRAND)->get();
    	$product = MxpProduct::where('product_id', $request->product_id)->get();

    	return view('product_management.update_product', compact('product'))->with('brands',$brands);
    }

    Public function addProduct(Request $request){
    	$roleManage = new RoleManagement();

        $validMessages = [
            'p_code.required' => 'Item Code field is required.',
            'p_code.unique' => 'Item Code has been entered before.',
            'p_erp_code.required' => 'ERP Code field is required.',
            'p_unit_price.required' => 'Unit Price field is required.',
            'p_weight_qty.required' => 'Weight Qty field is required.',
            'p_weight_qty.integer' => 'Weight Qty field is required.',
            'p_weight_amt.required' => 'Weight Amt field is required.',
            'p_weight_amt.integer' => 'Weight Amt field is required.',
            // 'p_brand.required' => 'Brand field is required.'
            ];
        $datas = $request->all();
    	$validator = Validator::make($datas, 
            [
    			'p_code' => 'required|unique:mxp_product,product_code',
    			'p_erp_code' => 'required',
    			// 'p_brand' => 'required'
		    ],
            $validMessages
    );

		// self::print_me($validator);
		
		if ($validator->fails()) {
			return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
		}

		$validationError = $validator->messages();

    	$createProduct = new MxpProduct();
    	$createProduct->product_code = $request->p_code;
    	$createProduct->product_name = $request->p_name;
    	$createProduct->product_description = $request->p_description;
    	$createProduct->brand = $request->p_brand;
    	$createProduct->erp_code = $request->p_erp_code;
    	$createProduct->unit_price = $request->p_unit_price;
    	$createProduct->weight_qty = $request->p_weight_qty;
    	$createProduct->weight_amt = $request->p_weight_amt;
        $createProduct->user_id = Auth::user()->user_id;
        $createProduct->status = $request->is_active;
    	$createProduct->action = self::CREATE_PRODUCT;
    	$createProduct->save();

		StatusMessage::create('new_product_create', 'New product Created Successfully');

		return \Redirect()->Route('product_list_view');    	
    }
    public function updateProduct(Request $request){
    	$roleManage = new RoleManagement();

        $validMessages = [
            'p_code.required' => 'The Product Code field is required.',
            'p_erp_code.required' => 'ERP Code field is required.',
            'p_brand.required' => 'Brand field is required.'
            ];
    	$validator = Validator::make($request->all(), 
            [
			'p_code' => 'required',
			'p_erp_code' => 'required',
            'p_brand' => 'required'
		   ],
           $validMessages
    );
		if ($validator->fails()) {
			return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
		}

		$validationError = $validator->messages();

    	$updateProduct = MxpProduct::find($request->product_id);
    	$updateProduct->product_code = $request->p_code;
    	$updateProduct->product_name = $request->p_name;
    	$updateProduct->product_description = $request->p_description;
    	$updateProduct->brand = $request->p_brand;
    	$updateProduct->erp_code = $request->p_erp_code;
    	$updateProduct->unit_price = $request->p_unit_price;
    	$updateProduct->weight_qty = $request->p_weight_qty;
    	$updateProduct->weight_amt = $request->p_weight_amt;
    	// $updateProduct->description_1 = $request->p_description1;
    	// $updateProduct->description_2 = $request->p_description2;
    	// $updateProduct->description_3 = $request->p_description3;
        // $updateProduct->description_4 = $request->p_description4;
        $updateProduct->user_id = Auth::user()->user_id;
    	$updateProduct->status = $request->is_active;
        $updateProduct->action = self::CREATE_PRODUCT;
    	$updateProduct->save();

		StatusMessage::create('update_product_create', $request->p_name .' update Successfully');

		return \Redirect()->Route('product_list_view');
    }

    public function deleteProduct(Request $request) {
		$product = MxpProduct::find($request->product_id);
		$product->delete();
		StatusMessage::create('new_product_delete',$product->product_name .' delete Successfully');
		return redirect()->Route('product_list_view');
	}

}
