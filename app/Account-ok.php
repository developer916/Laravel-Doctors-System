<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {

	//
    protected $table = 'accounts';
    protected $fillable = ['accountNumber', 'actName', 'location_id','contact_id'];

    //Functions
    public function scopeEagerLoadAll($query){
        return $query->with('actStatus'); //->with('relationship_2')->with('relationship_3');
    }
    public function accounting(){
        return $this->hasOne('App\ActAccounting');
    }
    public function actStatus(){
        return $this->hasOne('App\ActStatus');
    }
    public function office(){
        return $this->hasOne('App\ActOffice');
    }
    public function note(){
        return $this->hasOne('App\Note');
    }
    public function field(){
        return $this->hasMany('App\FieldService', 'account_id', 'accountNumber')->orderBy('service_date', 'desc');
    }
    public function actTax(){
        return $this->hasOne('App\ActTax');
    }
    public function salesmen(){
        return $this->hasOne('App\ActSalesman');
    }
    public function actTerms(){
        return $this->hasOne('App\ActTerm');
    }
    public function actInfo(){
        return $this->hasOne('App\ActInfo');
    }
    public function actType(){
        return $this->hasOne('App\ActType');
    }
    public function actCombine(){
        return $this->hasMany('App\ActCombine');
    }
    public function actService(){
        return $this->belongsToMany('App\Service');
    }
    public function scopeActive(){
        return $this->whereActStatus('0');
    }
}
