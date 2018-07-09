<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MxpBookingBuyerDetails extends Model
{
    protected $table = "mxp_bookingBuyer_details";

    protected $fillable = [
    			'user_id',
    			'booking_order_id',
    			'Company_name',
    			'C_sort_name',
    			'buyer_name',
    			'address_part1_invoice',
    			'address_part2_invoice',
    			'attention_invoice',
    			'mobile_invoice',
    			'telephone_invoice',
    			'fax_invoice',
    			'address_part1_delivery',
    			'address_part2_delivery',
    			'attention_delivery',
    			'mobile_delivery',
    			'telephone_delivery',
    			'fax_delivery'];
}
