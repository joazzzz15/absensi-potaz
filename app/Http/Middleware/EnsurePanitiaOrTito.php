<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePanitiaOrTito
{
    public function handle(Request $request, Closure $next): Response
    {
        $nama = $request->user()?->name;

        if (!in_array($nama, ['Panitia', 'Tito'], true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman Undian.');
        }

        return $next($request);
    }
}