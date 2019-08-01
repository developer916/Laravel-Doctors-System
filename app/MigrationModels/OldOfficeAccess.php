<?php

namespace App\MigrationModels;

use Illuminate\Database\Eloquent\Model;

class OldOfficeAccess extends Model
{
    //

	public $connection="workFlow";

	protected $table = 'office_access';
}
