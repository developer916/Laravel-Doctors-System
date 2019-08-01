<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ActOffice extends Model {
    
    //
    protected $table = 'act_offices';
    //protected $fillable = ['account_id', 'office_id'];
    protected $fillable = ['office_id'];
}