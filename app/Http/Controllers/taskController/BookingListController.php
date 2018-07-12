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

class BookingListController extends Controller
{
  public function bookingListView(){

    $bookingList = DB::table('mxp_bookingBuyer_details')
                      ->groupBy('booking_order_id')
                      ->orderBy('id','DESC')
                      ->paginate(15);

    return view('maxim.booking_list.booking_list_page',compact('bookingList'));
  }

  public function showBookingReport(Request $request){
  	$bookingReport = DB::select("call getBookinAndBuyerDeatils('".$request->bid."')");

    $companyInfo = DB::table('mxp_header')->where('header_type',11)->get();
  	
  	$gmtsOrSizeGroup = DB::select("SELECT gmts_color,GROUP_CONCAT(item_size) as itemSize,GROUP_CONCAT(item_quantity) as quantity from mxp_booking WHERE booking_order_id = '".$request->bid."' GROUP BY gmts_color");

  	return view('maxim.orderInput.reportFile',compact('bookingReport','companyInfo','gmtsOrSizeGroup'));
  }
}
