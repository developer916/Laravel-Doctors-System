<?php

namespace App\MigrationModels;

use Illuminate\Database\Eloquent\Model;

class OldInventory extends Model
{
    //

    public $connection="workFlow";

    public $table = "inventory_data";
}
