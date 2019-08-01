<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficeUser extends Model {
    
    //
    protected $table = 'office_user';
    //protected $fillable = ['account_id', 'office_id'];
    protected $fillable = ['id','office_id','user_id'];


	public function user(){
		return $this->hasOne('App\User')->orderBy('last_name', 'ASC')->get();
	}


}