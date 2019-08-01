<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldActivity extends Model {

	//
    protected $table = 'field_activites';
    protected $fillable = ['account_id', 'tech_id', 'hours', 'activity', 'audit', 'notes'];
    
//    public function fieldService(){
//        return $this->belongsTo('App\FieldService');
//    }
}