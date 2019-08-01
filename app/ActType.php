<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ActType extends Model {

	//
    protected $fillable = [ 'types_id', 'automatic', 'commission' ];
    
    //protected $table = 'act_types';
    //protected $fillable = ['account_id', 'types_id', 'automatic', 'commission'];

//    protected $casts = [
//        'automatic' => 'boolean',
//        'commission' => 'boolean',
//    ];
}
