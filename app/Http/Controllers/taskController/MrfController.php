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
      $booking_order_id = $request->booking_order_id;
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

      /**
      - This section check to one booking Challan value
      - empty or not empty ( this mean challan complte).
      - If empty all value then redirect create challan page.
      **/

      $length = sizeof($product_qty);
      $count = 0;
      foreach ($product_qty as $value) {
        if($value == 0 || $value < 0 ){
          $count++;
        }
      }

      if($count == $length){
        StatusMessage::create('erro_challan', 'Ops! Challan has been complte ');

        return \Redirect()->Route('dashboard_view');
      }

      /**
      - This Section create to concat all Get input
      - value by item id and store $tempValue Array.
      **/

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

      $combineUpdateDatas = $this->array_combine_($product_qty,$dbValue);

      foreach ($combineUpdateDatas as $keys => $datas) {
        if(sizeof($datas) > 1){
          foreach ($datas as $value) {
           $finalData[] = $value - $keys;
          }
        }else{
        $finalData[] = $datas - $keys;  //finalData[] is same as twoArray[]
      }
      }

      $tempp = $this->array_combine_($allId, $finalData);
      foreach ($tempp as $key => $value) {
          if(sizeof($value) > 1){
            $tempValues[$key] = implode(',', $value);
          }else{
            $tempValues[$key] = $value;
          }
      }

      $makeOneArray = [];
      foreach ($tempValue as $key => $value) {
        $makeOneArray[$key]['mrf_quantity'] = $value;
      }
      foreach ($tempValues as $key => $value) {
        $makeOneArray[$key]['item_quantity'] = $value;
      }

      /** Quantity and Mrf value Insert **/
      foreach ($makeOneArray as $key => $minusValues) {
        $challanMinusValueInsert = MxpBookingChallan::find($key);
        $challanMinusValueInsert->item_quantity = $minusValues['item_quantity'];
        $challanMinusValueInsert->mrf_quantity = $minusValues['mrf_quantity'];
        $challanMinusValueInsert->update();
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
            $insertMrfValue->mrf_person_name = $request->mrf_person_name;
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
            $insertMrfValue->shipmentDate = $request->mrf_shipment_date;
            $insertMrfValue->poCatNo = $bookingChallanValue->poCatNo;
            // $insertMrfValue->status = $bookingChallanValue->status;
            $insertMrfValue->action = self::CREATE_MRF;
            $insertMrfValue->save();
        }
      }
      $headerValue = DB::table("mxp_header")->where('header_type',11)->get();
      $buyerDetails = DB::table("mxp_bookingBuyer_details")->where('booking_order_id',$booking_order_id)->get();
      $footerData =[];
      $mrfDeatils = DB::table('mxp_MRF_table')->where('mrf_id',$mrf_id)->get();

      return view('maxim.mrf.mrfReportFile',compact('mrfDeatils','headerValue','buyerDetails','footerData'));
    }
}
