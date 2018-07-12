<?php

namespace App\Http\Controllers\taskController;

use App\Http\Controllers\dataget\ListGetController;
use App\Http\Controllers\Message\StatusMessage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RoleManagement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\MxpIpo;
use Validator;
use Auth;
use DB;


class TaskController extends Controller
{
    CONST CREATE_IPO = "create";
    CONST UPDATE_IPO = "update";

    public function getBuyerCompany(Request $request){
    	return json_encode(DB::table('mxp_party')->where([['name_buyer', $request->buyerName],['user_id',Auth::user()->user_id]])->get());
    }

    public function taskActionOrsubmited(Request $request){
     	$roleManage = new RoleManagement();
     	$datas = $request->all();

     	$taskType = $request->taskType;
     	if($taskType === 'booking'){
         	$taskType = "Create Booking";

         	$buyerDetails = DB::table('mxp_party')
         					->where([
         						['name_buyer',$request->buyerName],
         						['name',$request->companyName]				
         						])
         					->get();

            // $productDetails = DB::select("SELECT mp.product_code FROM mxp_product mp 
            // LEFT JOIN mxp_productSize mps ON (mps.product_code = mp.product_code)
            // LEFT JOIN mxp_gmts_color mgs ON (mgs.item_code = mps.product_code) GROUP BY mps.product_code, mgs.item_code");


         	return view('maxim.orderInput.orderInputIndex',compact('buyerDetails'))->with(['taskType' => $taskType]);

         }elseif($taskType === 'PI'){

            $formatTypes = $request->piFormat;
            $companyInfo = DB::table('mxp_header')->where('header_type',11)->get();
            $bookingDetails = DB::select('call getBookinAndBuyerDeatils("'.$request->bookingId.'")');
            if(empty($bookingDetails)){
                StatusMessage::create('empty_booking_data', 'This booking Id doesnot show any result . Please check booking Id !');

                return \Redirect()->Route('dashboard_view');
            }

            $footerData = DB::select("select * from mxp_reportFooter");

            return view('maxim.pi_format.piReportPage',compact('companyInfo','bookingDetails','footerData','formatTypes'));

         }elseif($taskType === 'IPO'){
            $roleManage = new RoleManagement();
            $ipoIncrease = $request->ipoIncrease;

            $validMessages = [
                'bookingId.required' => 'Booking Id is required.',
                'ipoIncrease.required' => 'Increase Value is required.'
                ];
            $datas = $request->all();
            $validator = Validator::make($datas, 
                  [
                    'bookingId' => 'required',
                    'ipoIncrease' => 'required'
                ],$validMessages);            

            if ($validator->fails()) {
              return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
            }
            $validationError = $validator->messages();
            $IpoUniqueID = "RGA".Carbon::now()->format('dmY')."-ACL-02-".mt_rand(10000,99999);

            $bookingDetails = DB::select("select user_id,booking_order_id,erp_code,item_code,item_description,GROUP_CONCAT(item_size) as item_size,GROUP_CONCAT(item_quantity) as item_quantity,item_price,matarial,gmts_color,others_color,orderDate,orderNo,shipmentDate,poCatNo,created_at,updated_at from mxp_booking where booking_order_id= '".$request->bookingId."' GROUP BY item_code");


            if (empty($bookingDetails)) {
              return \Redirect()->Route('dashboard_view');
            }
            foreach ($bookingDetails as $details) {
                $createIpo = new MxpIpo();
                $createIpo->user_id = Auth::user()->user_id;
                $createIpo->ipo_id = $IpoUniqueID;
                $createIpo->initial_increase = $ipoIncrease;
                $createIpo->booking_order_id = $details->booking_order_id;
                $createIpo->erp_code = $details->erp_code;
                $createIpo->item_code = $details->item_code;
                $createIpo->item_description = $details->item_description;
                $createIpo->item_size = $details->item_size;
                $createIpo->item_quantity = $details->item_quantity;
                $createIpo->item_price = $details->item_price;
                $createIpo->matarial = $details->matarial;
                $createIpo->gmts_color = $details->gmts_color;
                $createIpo->others_color = $details->others_color;
                $createIpo->orderDate = $details->orderDate;
                $createIpo->orderNo = $details->orderNo;
                $createIpo->shipmentDate = $details->shipmentDate;
                $createIpo->poCatNo = $details->poCatNo;
                $createIpo->status = self::CREATE_IPO;
                $createIpo->save();
            }
            $ipoDetails = DB::table("mxp_ipo")->where('ipo_id',$IpoUniqueID)->get();
            $buyerDetails = DB::table("mxp_bookingBuyer_details")->where('booking_order_id',$request->bookingId)->get();
            $headerValue = DB::table("mxp_header")->where('header_type',11)->get();
            return view('maxim.ipo.ipoBillPage',[
                'headerValue' => $headerValue,
                'initIncrease' => $request->ipoIncrease,
                'buyerDetails' => $buyerDetails,
                'sentBillId' => $ipoDetails
            ]);

         }elseif($taskType === 'MRF'){
            $data = $request->all();
            $booking_order_id = $request->bookingId;
            $validMessages = [
                    'bookingId.required' => 'Booking Id field is required.'
                    ];
            $validator = Validator::make($datas, 
                [
                    'bookingId' => 'required',
                ],
                $validMessages
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
            }

            $validationError = $validator->messages();

            $bookingDetails = DB::select("SELECT * FROM mxp_booking_challan WHERE booking_order_id = '".$request->bookingId."' GROUP BY item_code");
            // self::print_me($bookingDetails);

            $buyerDetails = DB::select("SELECT * FROM mxp_bookingBuyer_details WHERE booking_order_id = '".$request->bookingId."'");

            if(empty($bookingDetails)){
                StatusMessage::create('empty_booking_data', 'This booking Id does not show any result . Please check booking Id !');

                return \Redirect()->Route('dashboard_view');
            }

            $MrfDetails = DB::select("select * from mxp_MRF_table where booking_order_id = '".$request->bookingId."' GROUP BY mrf_id");

            return view('maxim.mrf.mrf',compact('bookingDetails','MrfDetails','booking_order_id'));

         }elseif($taskType === 'challan'){

            $validMessages = [
                    'bookingId.required' => 'Booking Id field is required.'
                    ];
            $validator = Validator::make($datas, 
                [
                    'bookingId' => 'required',
                ],
                $validMessages
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
            }

            $validationError = $validator->messages();

            $bookingDetails = DB::select("SELECT *,GROUP_CONCAT(item_size) as itemSize, GROUP_CONCAT(item_quantity) as quantity FROM mxp_booking_challan WHERE booking_order_id = '".$request->bookingId."' GROUP BY item_code");

            $buyerDetails = DB::select("SELECT * FROM mxp_bookingBuyer_details WHERE booking_order_id = '".$request->bookingId."'");

            if(empty($bookingDetails)){
                StatusMessage::create('empty_booking_data', 'This booking Id does not show any result . Please check booking Id !');

                return \Redirect()->Route('dashboard_view');
            }

            return view('maxim.challan.challan',compact('bookingDetails'));
         }else{
            $validMessages = [
                    'taskType.required' => 'TaskType field is required.'
                    ];
            $validator = Validator::make($datas, 
                [
                    'taskType' => 'required',
                ],
                $validMessages
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
            }

            $validationError = $validator->messages();
         }
    }
}
