<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldService extends Model {

    protected $table = 'field_services';
    protected $fillable = ['account_id' , 'tech_id', 'hours', 'audit', 'notes', 'service_date', 'old_number'];

    public function getServiceDateAttribute($value){
        return date('m/d/Y', strtotime($value) );
    }
    public function fieldData(){
        return $this->hasMany('App\FieldData', 'field_service_id', 'id');
    }
    public function fieldDataIns(){
        return $this->hasMany('App\FieldData', 'field_service_id', 'id');
    }
    public function account(){
        return $this->belongsTo('App\Account');
    }
    public function accountField(){
        return $this->hasOne('App\Account');
    }
    public function tech(){
        return $this->hasOne('App\Technician');
    }
}