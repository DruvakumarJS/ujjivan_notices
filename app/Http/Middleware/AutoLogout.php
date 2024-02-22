<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Auth;

class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    protected $session;
    protected $timeout = 3600;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $userLastActivity = $this->session->get('lastActivity');

        if (isset($userLastActivity) && (time() - $userLastActivity > $this->timeout)) {
            Auth::logout();
            $this->session->forget('lastActivity');         
            return redirect('/login')->withMessage('You have been logged out due to inactivity');
        }

        $this->session->put('lastActivity', time());

        return $next($request);
    }
}
