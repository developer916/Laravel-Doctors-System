<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldData extends Model {

    protected $table = 'field_data';
    protected $fillable = ['material_id', 'quantity', 'old_number', 'field_service_id'];
    
    public function fieldService(){
        return $this->belongsTo('App\FieldService');
    }

    public function material(){
        return $this->hasOne('App\material', 'id', 'material_id');
    }


}