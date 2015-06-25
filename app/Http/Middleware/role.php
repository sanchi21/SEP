<?php namespace App\Http\Middleware;

use Closure;
use Auth;

class role {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

        if (Auth::user() && Auth::User()->primarygroup=='AdminFull' )
        {
            return $next($request);
        }

        return redirect('accessDenied');


//		return $next($request);
	}

}
