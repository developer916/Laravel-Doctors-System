<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    //
	protected $table = 'user_address';
	protected $fillable = [ 'address1', 'address2', 'city', 'state', 'zipcode' ];
}