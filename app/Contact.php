<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    //
    protected $table = 'contacts';
    protected $fillable = ['firstName', 'lastName', 'title', 'phone_work', 'phone_cell', 'phone_fax', 'phoneExten', 'email'];

    //Accessors
    public function getPhoneWorkAttribute($value)
    {
        if(strlen($value) > 10){
            $rtn = "" . substr($value, 0, 3) . "-" . substr($value, 3, 3) . " - " . substr($value, 6, 4). " Ext " . substr($value, 10);
            $rtn = $value;
        }else if(strlen($value) == 10){
            $rtn = "" . substr($value, 0, 3) . "-" . substr($value, 3, 3) . "-" . substr($value, 6);
        }else{
            $rtn = "";
        }
        return $rtn;
    }
    public function getPhoneFaxAttribute($value)
    {
        if(strlen($value) > 10){
            $rtn = "" . substr($value, 0, 3) . "-" . substr($value, 3, 3) . " - " . substr($value, 6, 4). " Ext " . substr($value, 10);
            $rtn = $value;
        }else if(strlen($value) == 10){
            $rtn = "" . substr($value, 0, 3) . "-" . substr($value, 3, 3) . "-" . substr($value, 6);
        }else{
            $rtn = "";
        }
        return $rtn;
    }
    public function getPhoneCellAttribute($value)
    {
 
        if(strlen($value) > 10){
            $rtn = "" . substr($value, 0, 3) . "-" . substr($value, 3, 3) . " - " . substr($value, 6, 4). " Ext " . substr($value, 10);
            $rtn = $value;
        }else if(strlen($value) == 10){
            $rtn = "" . substr($value, 0, 3) . "-" . substr($value, 3, 3) . "-" . substr($value, 6);
        }else{
            $rtn = "";
        }
        return $rtn;
    }

    //Mutators preg_replace("/[^0-9]/", "", $value);
    public function setPhoneWorkAttribute($value)
    {
        $this->attributes['phone_work'] = preg_replace("/[^0-9]/", "", $value);
    }
    public function setPhoneCellAttribute($value)
    {
        $this->attributes['phone_cell'] = preg_replace("/[^0-9]/", "", $value);
    }
    public function setPhoneFaxAttribute($value)
    {
        $this->attributes['phone_fax'] = preg_replace("/[^0-9]/", "", $value);
    }
}
