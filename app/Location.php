<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class
Location extends Model {

	//
    //protected $table = 'locations';
    protected $fillable = ['care_of', 'address1', 'address2','address3' , 'city', 'state_id', 'zipcode'];

    //Accessors
    public function getZipcodeAttribute($value)
    {
        if(strlen($value) > 5){
            return substr($value, 0, 5) . "-" . substr($value, 5);
        }else{
            return $value;
        }
    }

    //Mutators
    public function setZipcodeAttribute($value)
    {
        $this->attributes['zipcode'] = preg_replace("/[^0-9]/", "", $value);
    }
}
