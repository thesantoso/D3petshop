<?php

namespace App\Http\Middleware;

use Closure;

class Member
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

        if (!$user) {
            return redirect()
            ->route('front::login.form', [
                'redirect' => $request->path()
            ])
            ->with('warning', 'Anda diharuskan login terlebih dahulu.');
        }

        if ($user->isAdmin()) {
            return abort(403, "Admin tidak diizinkan mengakses halaman ini.");
        }

        return $next($request);
    }
}
