<?php

namespace App\MigrationModels;

use Illuminate\Database\Eloquent\Model;

class OldUserPerms extends Model
{
    //

    public $connection="workFlow";

    public $table = "users_perms";
}
