<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ActInfo extends Model {

	//
    protected $table = 'act_info';
    protected $fillable = [ 'date_since', 'date_begin', 'date_end', 'contact_id','po_number', 'permit', 'permit_expire' ];
    //protected $fillable = [ 'account_id', 'date_since', 'date_begin', 'date_end','po_number', 'permit', 'permit_expire', 'contact_id' ];

    public function getDateSinceAttribute($value)
    {
        return date('m/d/Y', strtotime($value));
    }
    public function getDateBeginAttribute($value)
    {
        return date('m/d/Y', strtotime($value));
    }
    public function getDateEndAttribute($value)
    {
        return date('m/d/Y', strtotime($value));
    }
    public function getPermitExpireAttribute($value)
    {
        if ($value != '1970-01-01' && $value != '0000-00-00' && strtotime($value) > strtotime('2000/01/01')) {

            return date('m/d/Y', strtotime($value));
        } else {
            return '';

        }
    }

}
