<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpFooter extends Model
{
    protected $table = 'mxp_pageFooter';
	protected $primaryKey = 'footer_id';

	protected $fillable = ['user_id','title','status','action'];
}
