<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() &&
            $request->user()->must_reset_password &&
            ! $request->routeIs('profile.edit', 'password.update', 'logout', 'profile.update')) {

            return redirect()->route('profile.edit')
                ->with('warning', 'You must change your password before proceeding.');
        }

        return $next($request);
    }
}
