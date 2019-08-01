<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model {

	//
    protected $table = 'technicians';
    protected $fillable = ['code', 'name', 'office', 'rate', 'active'];

    public function office(){
        return $this->hasOne('App\Office', 'office');
    }
}