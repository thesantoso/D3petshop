<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        $user = auth()->user();

        if (!$user || !$user->isAdmin()) {
            return redirect()
            ->route('admin::login.form', [
                'redirect' => $request->path()
            ])
            ->with('warning', 'Anda diharuskan login terlebih dahulu.');
        }

        return $next($request);
    }
}
