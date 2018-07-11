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

class MrfController extends Controller
{
  const CREATE_MRF = "create";
  const UPDATE_MRF = "update";

	function array_combine_($keys, $values)
	{
	    $result = array();
	    foreach ($keys as $i => $k) {
	        $result[$k][] = isset($values[$i]) ? $values[$i] : 0;
	    }
	    array_walk($result, create_function('&$v', '$v = (count($v) == 1)? array_pop($v): $v;'));
	    return  $result;
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

      // self::print_me($mainData);

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
      }

      /** Item Quantity value Insert **/

      foreach ($tempValues as $key => $Minusvalue) {
        $challanMinusValueInsert = MxpBookingChallan::find($key);
        $challanMinusValueInsert->item_quantity = $Minusvalue;
        $challanMinusValueInsert->save();
      }

      $cc = MxpMrf::count();
      $count = str_pad($cc + 1, 4, 0, STR_PAD_LEFT);
      $id = "MRF"."-";
      $date = date('dmY') ;
      $mrf_id = $id.$date."-".$count;

      foreach ($mainData as $key => $value) {
        $getBookingChallanValue = DB::table("mxp_booking_challan")->where('id',$key)->get();
        foreach ($getBookingChallanValue as $bookingChallanValue) {
            $insertMrfValue = new MxpMrf();
            $insertMrfValue->user_id = Auth::user()->user_id;
            $insertMrfValue->mrf_id = $mrf_id;
            $insertMrfValue->booking_order_id = $bookingChallanValue->booking_order_id;
            $insertMrfValue->erp_code = $bookingChallanValue->erp_code;
            $insertMrfValue->item_code = $bookingChallanValue->item_code;
            $insertMrfValue->item_size = $bookingChallanValue->item_size;
            $insertMrfValue->item_quantity = $bookingChallanValue->item_quantity;
            $insertMrfValue->mrf_quantity = $value;
            $insertMrfValue->item_price = $bookingChallanValue->item_price;
            $insertMrfValue->matarial = $bookingChallanValue->matarial;
            $insertMrfValue->gmts_color = $bookingChallanValue->gmts_color;
            $insertMrfValue->orderDate = $bookingChallanValue->orderDate;
            $insertMrfValue->orderNo = $bookingChallanValue->orderNo;
            $insertMrfValue->shipmentDate = $bookingChallanValue->shipmentDate;
            $insertMrfValue->poCatNo = $bookingChallanValue->poCatNo;
            // $insertMrfValue->status = $bookingChallanValue->status;
            $insertMrfValue->action = self::CREATE_MRF;
            $insertMrfValue->save();
        }
      }
    }
}
