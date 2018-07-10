<?php

namespace App\Http\Controllers\taskController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MrfController extends Controller
{
    public function addMrf(Request $request){
    	$data = $request->all();
    	self::print_me($data);
    }
}
