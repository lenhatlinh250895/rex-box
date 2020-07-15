<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\User;
class CheckLogin
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
        if (session('user')) {
			$user = User::find(session('user')->User_ID);
	        if($user->User_Level != 1){
				return redirect()->route('getLogout');
			}
			if($user->User_Block == 1){
				return redirect()->route('getLogout');
			}
            return $next($request);
        }
        return redirect()->route('getLogin');

    }
}
