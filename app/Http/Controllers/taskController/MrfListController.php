<?php

namespace App\Http\Controllers\taskController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MrfListController extends Controller
{
    public function mrfListView(){
    	$bookingList =[];
    	return view('maxim.mrf.list.mrfList',compact('bookingList'));
    }
}
