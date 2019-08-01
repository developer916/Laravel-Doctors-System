<?php

namespace App\Http\Middleware;

use App\UserLevel;
use Closure;
use Auth;

class CanEditInventory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$userLevel = Auth::user()->level;

    	if ( $userLevel != UserLevel::ADMIN_LEVEL_ID &&
			 $userLevel != UserLevel::AFRW_LEVEL_ID &&
			!Auth::user()->is_super_admin
		)
		{
			abort(401, 'Unauthorized');
		}

        return $next($request);
    }
}
