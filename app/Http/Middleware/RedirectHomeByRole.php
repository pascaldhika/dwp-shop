<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectHomeByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {

            $user = auth()->user();

            // Super Admin dan Admin tetap boleh ke /home
            if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
                return $next($request);
            }

            // User selain Admin diarahkan ke /shop
            return redirect()->route('app.shop.index');
        }

        return $next($request);
    }
}
