<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            //role = 1 => admin
            //role = 0 => user
            if (Auth::user()->role == '1') {
                return $next($request);
            } else {
                return response([
                    'message' => 'access denied'
                ]);
            }
        } else {
            return response([
                'message' => 'unauthorised access'
            ]);
        }
        return $next($request);
    }
}
