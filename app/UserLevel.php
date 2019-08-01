<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    protected $table = 'user_levels';

    const ADMIN_LEVEL_ID = '1';
    const AFRW_LEVEL_ID = '2';
}
