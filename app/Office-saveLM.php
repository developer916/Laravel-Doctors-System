<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model {
    
    //
    //protected $table = 'offices';
    //protected $fillable = ['abvr','officeName'];
    
	public function office(){
		return $this->belongsToMany('App\User')->orderBy('last_name', 'ASC')->get();
	}
}