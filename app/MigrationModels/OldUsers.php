<?php

namespace App\MigrationModels;

use Illuminate\Database\Eloquent\Model;

class OldUsers extends Model
{
    //

    public $connection="workFlow";

    public $table = "users";

	public function perm()
	{
		return $this->hasOne('App\MigrationModels\OldUserPerms');
	}
}
