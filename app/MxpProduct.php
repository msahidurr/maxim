<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpProduct extends Model {

	protected $table = 'mxp_product';
	protected $primaryKey = 'product_id';

	protected $fillable = ['product_code','product_name', 'product_description', 'brand', 'erp_code','unit_price','weight_qty','weight_amt','description_1','description_2','description_3','description_4','user_id','status','action'];
}
