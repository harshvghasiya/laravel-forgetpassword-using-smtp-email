<?php

namespace App\Http\Middleware;

use Closure;

class PasswordMiddleware
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
        $afterFive=Carbon::now('Asia/kolkata');
        $user_created_at=Carbon::createFromTimeString($user->created_at,'Asia/kolkata');
        if ($afterFive->diffInMinutes($user_created_at)>=5) {
            return back();
        }
        return $next($request);
    }
}
