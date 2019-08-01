<?php namespace App\MigrationModels;

use Illuminate\Database\Eloquent\Model;

class OldAccount extends Model {

    public $connection="workFlow";

    public $table = "accounts";

    public function fields(){
        return $this->hasMany('App\MigrationModels\OldField', 'ACCTNUM', 'ACCTNUM');
    }
}
