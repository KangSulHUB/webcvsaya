<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminSessionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('is_admin')) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'Silakan login admin terlebih dahulu.');
        }

        return $next($request);
    }
}
