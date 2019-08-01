<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ActAccounting extends Model {

	//
    protected $fillable = ['budget', 'yearlyAmount', 'billing','initialStart' ,
        'initialBudget'];
    
    //protected $table = 'act_accountings';
    //protected $fillable = ['account_id','budget', 'yearlyAmount', 'billing','initialStart', 'initialBudget'];
    
    public function note(){
        return $this->belongsTo('App\Account');
    }
}
