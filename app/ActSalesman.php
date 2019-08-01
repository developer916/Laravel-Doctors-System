<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ActSalesman extends Model {

	//
    protected $table = 'act_salesmen';
    //protected $fillable = ['account_id', 'salesmen_id'];
    protected $fillable = ['salesmen_id'];
}