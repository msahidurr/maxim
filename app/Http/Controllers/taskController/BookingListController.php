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
                      ->paginate(20);

    return view('maxim.booking_list.booking_list_page',compact('bookingList'));
  }
}
