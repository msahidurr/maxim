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

       /**
      - This Array most important to create challan
      - and update BookingChallan table
      **/

        $tempValue = [];
        $quantity = [];
        $dbValue = [];
        $finalData = [];
        $tempValues = [];


      $temp = $this->array_combine_ ($allId ,$product_qty);

      foreach ($temp as $key => $value) {
          if(sizeof($value) > 1){
            $tempValue[$key]= implode(',', $value);
          }else{
            $tempValue[$key] = $value;
          }
        }

        /**
      - This section most importent to update all array
      - value. Becouse this section create to array_combine
      - database primary id.
      - @param $maindata
      **/

      $one_uniq = array_unique($allId);
      $mainData = array_combine($one_uniq, $tempValue);


      /** This code only for mxp_booking_Challan Table update **/

      foreach($tempValue as $key => $value){
        $findChallanUpdate = DB::select(" select item_quantity from mxp_booking_challan where id ='".$key."'");
        
        foreach ($findChallanUpdate as $challanValues) {
          $quantity[] = explode(',', $challanValues->item_quantity);
        }
      }

      foreach ($quantity as $key => $value) {
        foreach ($value as $item) {
          $dbValue[] = $item;
        }
      }

      $combineUpdateData = array_combine($dbValue, $product_qty);
      
      foreach ($combineUpdateData as $keys => $datas) {
        $finalData[] = $keys - $datas;  //finalData[] is same as twoArray[]
      }

      $tempp = $this->array_combine_($allId, $finalData);
      foreach ($tempp as $key => $value) {
          if(sizeof($value) > 1){
            $tempValues[$key] = implode(',', $value);
          }else{
            $tempValues[$key] = $value;
          }
      }

      /** Mrf value Insert **/

      foreach ($tempValue as $key => $Minusvalues) {
        $challanMinusValueInsert = MxpBookingChallan::find($key);
        $challanMinusValueInsert->mrf_quantity = $Minusvalues;
        $challanMinusValueInsert->save();
        self::print_me($challanMinusValueInsert);
      }

      /** Item Quantity value Insert **/

      foreach ($tempValues as $key => $Minusvalue) {
        $challanMinusValueInsert = MxpBookingChallan::find($key);
        $challanMinusValueInsert->item_quantity = $Minusvalue;
        $challanMinusValueInsert->save();
      }
      $aaa = MxpBookingChallan::find(33);
      print_r("<pre>");
      print_r($aaaaa);
      // print_r($quantity);
      // print_r($dbValue);
      // print_r($combineUpdateData);
      // print_r($finalData);
      // print_r($tempp);
      // print_r($tempValues);
      // print_r($challanMinusValueInsert);
      print_r("</pre>");
    }
}
