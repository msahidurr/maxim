<?php

namespace App\Http\Controllers\taskController;

use App\Http\Controllers\dataget\ListGetController;
use App\Http\Controllers\Message\StatusMessage;
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
    	$bookingList = MxpMrf::where('user_id',Auth::user()->user_id)->paginate(20);
    	return view('maxim.mrf.list.mrfList',compact('bookingList'));
    }
}
