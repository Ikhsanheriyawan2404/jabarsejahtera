<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Resources\UserResource;

class IsAdmin
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
        if (auth()->user() && auth()->user()->role == 1) {
            return $next($request);
        }

        return response()->json(new UserResource(false, 'Anda tidak memiliki akses'), 403);
    }
}
