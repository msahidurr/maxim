<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpProductSize extends Model
{
    protected $table = 'mxp_productSize';
	protected $primaryKey = 'proSize_id';

	protected $fillable = ['user_id','product_code','product_size','status','action'];
}
