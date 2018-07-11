<?php

namespace App\Http\Controllers\taskController;

use App\Http\Controllers\dataget\ListGetController;
use App\Http\Controllers\Message\StatusMessage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RoleManagement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\MxpMrf;
use Validator;
use Auth;
use DB;

class MrfController extends Controller
{
	function array_combine_($keys, $values)
	{
	    $result = array();
	    foreach ($keys as $i => $k) {
	        $result[$k][] = $values[$i];
	    }
	    array_walk($result, create_function('&$v', '$v = (count($v) == 1)? array_pop($v): $v;'));
	    return    $result;
	}
    public function addMrf(Request $request){
      	
      	$datas = $request->all();
    	$allId = $datas['allId'];
    	$product_qty = $datas['product_qty'];
    	$value = $this->array_combine_ ($allId ,$product_qty);
    	print_r("<pre>");
    	print_r($allId);
    	print_r($product_qty);
    	print_r($value);
    	print_r("</pre>");
    }
}
