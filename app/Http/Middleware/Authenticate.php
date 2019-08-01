<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	private $except = [
		'/',
		'auth/*',
		'migrate/*'
	];

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}


	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->guest() && !$this->shouldPassThrough($request))
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('/');
			}
		}

		return $next($request);
	}

	/**
	 * Determine if the request has a URI that should pass through verification.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return bool
	 */
	private function shouldPassThrough($request)
	{
		foreach ($this->except as $except) {
			if ( $request->is($except) )
			{
				return true;
			}
		}

		return false;
	}

}
