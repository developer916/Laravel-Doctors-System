<?php

namespace App\MigrationModels;

use Illuminate\Database\Eloquent\Model;

class OldTaxDistrict extends Model {

    public $connection="workFlow";

    public $table = "list_taxdistricts";

    public function fields(){
        return $this->hasMany('App\MigrationModels\OldField', 'ACCTNUM', 'ACCTNUM');
    }
}
