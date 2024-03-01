<?php

namespace App\Http\Middleware;

use App\Enums\AccountEnums;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class is_admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            return response()->failed("unauthenticated", 401);
        }
        if (!in_array($user->account['value'], [AccountEnums::admin->value, AccountEnums::both->value])) {
            return response()->failed("Must be an admin");
        }
        return $next($request);
    }
}
