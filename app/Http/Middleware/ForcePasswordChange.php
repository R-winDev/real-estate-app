<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->must_change_password) {
            if ($request->route()->getName() !== 'password.force.show' &&
                $request->route()->getName() !== 'password.force.update' &&
                $request->route()->getName() !== 'logout') {
                return redirect()->route('password.force.show');
            }
        }

        return $next($request);
    }
}
