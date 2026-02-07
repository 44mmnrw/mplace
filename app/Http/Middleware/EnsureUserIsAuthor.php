<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('author.auth.login')
                ->with('error', 'Пожалуйста, войдите в систему');
        }

        // Check if user has author profile
        if (!auth()->user()->author) {
            return redirect()->route('home')
                ->with('error', 'У вас нет профиля автора');
        }

        return $next($request);
    }
}
