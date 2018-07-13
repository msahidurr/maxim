<?php

namespace App\Http\Controllers\taskController;

use App\Http\Controllers\dataget\ListGetController;
use App\Http\Controllers\Message\StatusMessage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RoleManagement;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;

class ChallanListController extends Controller
{
     public function challanListView(){
     	$challanDetails = DB::table('Mxp_multipleChallan')
                      ->groupBy('challan_id')
                      ->orderBy('id','DESC')
                      ->paginate(15);
     	return view('maxim.challan.list.challanList',compact('challanDetails'));
     }


     public function showChallanReport(Request $request){
     	$headerValue = DB::table("mxp_header")->where('header_type',11)->get();
    	$multipleChallan = DB::select(" select * from Mxp_multipleChallan where challan_id ='".$request->cid."'");
        $buyerDetails = DB::table("mxp_bookingBuyer_details")->where('booking_order_id',$request->bid)->get();
    	$footerData = DB::select("select * from mxp_reportFooter");

    	return view('maxim.challan.challanBoxingPage',
        [
        	'footerData' => $footerData,
          'headerValue' => $headerValue,
        	'buyerDetails' => $buyerDetails,
        	'multipleChallan' => $multipleChallan
        ]);
     }
}
