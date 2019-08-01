<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ActCombine extends Model {

	//

    protected $fillable = ['primary_account_id', 'joined_account_id'];
}
