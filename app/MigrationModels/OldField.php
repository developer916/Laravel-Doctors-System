<?php namespace App\MigrationModels;

use Illuminate\Database\Eloquent\Model;

class OldField extends Model {

    public $connection="workFlow";

    public $table="field";

    public function datas()
    {
        return $this->hasMany('App\MigrationModels\OldData', 'NUMBER', 'NUMBER');
    }

}
