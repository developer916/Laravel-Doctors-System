<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ActTax extends Model {

	//
    protected $fillable = [ 'account_id', 'taxState', 'taxDistrict', 'exempt', 'exemptNumber' ];
    
    //protected $table = 'act_taxes';
    //protected $fillable = [ 'account_id', 'taxState', 'taxDistrict', 'exemptNumber' ];
}