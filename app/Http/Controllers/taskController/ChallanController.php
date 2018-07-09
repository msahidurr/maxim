<?php

namespace App\Http\Controllers\taskController;

use App\Http\Controllers\dataget\ListGetController;
use App\Http\Controllers\Message\StatusMessage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RoleManagement;
use Illuminate\Http\Request;
use App\Model\MxpBookingChallan;

use App\Model\MxpMultipleChallan;
use App\Model\MxpChallan;
use Carbon\Carbon;
use Validator;
use Auth;
use DB;

class ChallanController extends Controller
{	
	const CREATE_MULTIPLE_CHALLAN = "create";
  const UPDATE_MULTIPLE_CHALLAN = "update";

	public function autoInrement($value){

        return str_pad($value + 1, 3, "0", STR_PAD_LEFT);
    }

   public function array_combine_($keys, $values){
      $result = array();
      foreach ($keys as $i => $k) {
          $result[$k][] = isset($values[$i]) ? $values[$i] : 0;
      }
      array_walk($result, create_function('&$v', '$v = (count($v) == 1)? array_pop($v): $v;'));
      return $result;
  }
  public function addChallan(Request $request){

      $table = $request->all();
      $oneArray = $table['allId'];
      $twoArray = $table['product_qty'];

      /**
      - This Array most important to create challan
      - and update BookingChallan table
      **/
      
      $dbValue = [];
      $quantity = [];
      $finalData = [];
      $tempValue = [];
      $tempValues = [];

      /**
      - This section check to one booking Challan value
      - empty or not empty ( this mean challan complte).
      - If empty all value then redirect create challan page.
      **/

      $length = sizeof($twoArray);
      $count = 0;
      foreach ($twoArray as $value) {
        if($value == 0 || $value < 0 ){
          $count++;
        }
      }

      if($count == $length){
        StatusMessage::create('erro_challan', 'Ops! Challan has been complte ');

        return \Redirect()->Route('dashboard_view');
      }


      /** this code only for Challan increment id genarate **/

      $maxIncrement = DB::select("select max(incrementValue) from Mxp_multipleChallan group by incrementValue");
        if(sizeof($maxIncrement) == 0){
            $number = 0;
        }else{
          foreach ($maxIncrement as $value) {
            foreach ($value as $key => $aa) {
                $number = intval($aa);
            }
        }  
        }
      $incrementValue = self::autoInrement($number);

      $findSortNames = "";
      foreach ($mainData as $keys => $sortNames) {
        $findSortName = DB::select(" select sort_name from mxp_challan where id ='".$keys."'");
        foreach ($findSortName as $value) {
          $findSortNames = $value;
        }
      }
      $MultipleChallanUniqueID = "CHA-".Carbon::now()->format('Ymd')."-".$findSortNames->sort_name."-".$incrementValue;
      $MultipleCheckingUniqueID = "CHK-".Carbon::now()->format('Ymd')."-".$findSortNames->sort_name."-".$incrementValue;

      /** End this code only for Challan increment id genarate **/

      /**
      - This Section create to concat all Get input
      - value by item id and store $tempValue Array.
      **/

      $temp = self::array_combine_($oneArray, $twoArray);
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

      $one_uniq = array_unique($oneArray);
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
      //   print_r("<pre>");
      //   print_r($twoArray);
      // self::print_me($dbValue);

      $combineUpdateData = array_combine($dbValue, $twoArray);
      // self::print_me($combineUpdateData);
      
      foreach ($combineUpdateData as $keys => $datas) {
        $finalData[] = $keys - $datas;  //finalData[] is same as twoArray[]
      }

      $tempp = self::array_combine_($oneArray, $finalData);
      foreach ($tempp as $key => $value) {
          if(sizeof($value) > 1){
            $tempValues[] = implode(',', $value);
          }else{
            $tempValues[] = $value;
          }
      }

      $challanTableUpdate = array_combine($one_uniq, $tempValues);
      $count_challan = 1;
      foreach ($challanTableUpdate as $key => $value) {
        $count = DB::select(" select * from mxp_booking_challan where id ='".$key."'");
        foreach ($count as $countvalue) {
          $findChallanUpdateData = MxpBookingChallan::find($key);
          $findChallanUpdateData->item_quantity = $value;
          // $findChallanUpdateData->count_challan = $count_challan + $countvalue->count_challan;
          $findChallanUpdateData->save();
        } 

      }

      /** End this code for update mxp_booking_Challan Table  **/

		foreach ($mainData as $key => $value) {
		$findChallan = DB::select(" select * from mxp_booking_challan where id ='".$key."'");
		// self::print_me($findChallan);
		foreach ($findChallan as $challanValue) {

		  $insertMultipleChallan = new MxpMultipleChallan();
		  $insertMultipleChallan->user_id = Auth::user()->user_id;

		  $insertMultipleChallan->challan_id = $MultipleChallanUniqueID;
		  $insertMultipleChallan->checking_id = $MultipleCheckingUniqueID;

		  $insertMultipleChallan->bill_id = $challanValue->bill_id;
		  $insertMultipleChallan->erp_code = $challanValue->erp_code;
		  $insertMultipleChallan->item_code = $challanValue->item_code;
		  $insertMultipleChallan->oss = $challanValue->oss;
		  $insertMultipleChallan->style = $challanValue->style;
		  $insertMultipleChallan->item_size = $challanValue->item_size;
		  $insertMultipleChallan->quantity = $value;
		  $insertMultipleChallan->unit_price = $challanValue->unit_price;
		  $insertMultipleChallan->total_price = $challanValue->total_price;
		  $insertMultipleChallan->party_id = $challanValue->party_id;
		  $insertMultipleChallan->name_buyer = $challanValue->name_buyer;
		  $insertMultipleChallan->name = $challanValue->name;
		  $insertMultipleChallan->address = $challanValue->address;
		  $insertMultipleChallan->attention_invoice = $challanValue->attention_invoice;
		  $insertMultipleChallan->mobile_invoice = $challanValue->mobile_invoice;
		  $insertMultipleChallan->incrementValue = $incrementValue;
		  $insertMultipleChallan->status = self::CREATE_MULTIPLE_CHALLAN;
		  $insertMultipleChallan->save();
		}        
		}

    	$headerValue = DB::select("select * from mxp_header");
    	$multipleChallan = DB::select(" select * from Mxp_multipleChallan where challan_id ='".$MultipleChallanUniqueID."'");

    	$footerData = DB::select("select * from mxp_reportFooter");

    	return view('maxim.challan.challanBoxingPage',
        [
        	'footerData' => $footerData,
        	'headerValue' => $headerValue,
        	'multipleChallan' => $multipleChallan,
        ]);
    }
}