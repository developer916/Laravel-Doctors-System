<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Gate;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function can($permission)
    {
        return Gate::allows($permission);

    }

    public function cannot($permission)
    {
        return Gate::denies($permission);
    }

    public function defaultDeny()
    {
        return redirect('/dash');
    }
}
