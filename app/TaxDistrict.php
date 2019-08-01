<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxDistrict extends Model {

	//
    //protected $table = 'tax_districts';
    protected $fillable = ['name', 'state_id', 'id_code', 'percent', 'old_id'];
}