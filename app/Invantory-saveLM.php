<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Invantory extends Model {

    //
    //protected $table = 'invantories';
	protected $fillable = ['office_id', 'mat_id', 'begin_amount', 'end_amount', 'purchased_amount', 'cost'];
}