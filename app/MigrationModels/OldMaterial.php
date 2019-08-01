<?php

namespace App\MigrationModels;

use Illuminate\Database\Eloquent\Model;

class OldMaterial extends Model
{
    //

    public $connection="workFlow";

    public $table = "material";
}
