<?php

namespace App\Http\Middleware;

use Closure;

class UserMustBeActive {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next ) {
		$user = $request->user();
		if ( $user && $user->isActive() ) {
			return $next( $request );
		}
		$request->session()->invalidate();

		abort( 403);
	}
}
