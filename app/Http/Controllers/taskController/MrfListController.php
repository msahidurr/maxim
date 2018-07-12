<?php

namespace App\Http\Controllers\taskController;

use App\Http\Controllers\dataget\ListGetController;
use App\Http\Controllers\Message\StatusMessage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RoleManagement;
use Illuminate\Http\Request;
use App\Model\MxpBookingChallan;
use App\Model\MxpMrf;
use Carbon\Carbon;
use Validator;
use Auth;
use DB;

class MrfListController extends Controller
{
    public function mrfListView(){
    	$bookingList = DB::table('mxp_MRF_table')
    						->where('user_id',Auth::user()->user_id)
    						->groupBy('mrf_id')
                      		->orderBy('id','DESC')
                      		->paginate(15);
    	return view('maxim.mrf.list.mrfList',compact('bookingList'));
    }

    public function showMrfReport(Request $request){
      $mrfDeatils = DB::table('mxp_MRF_table')->where('mrf_id',$request->mid)->get();
	  $headerValue = DB::table("mxp_header")->where('header_type',11)->get();
      $buyerDetails = DB::table("mxp_bookingBuyer_details")->where('booking_order_id',$request->bid)->get();
      $footerData =[];
      return view('maxim.mrf.mrfReportFile',compact('mrfDeatils','headerValue','buyerDetails','footerData'));
    }
}
