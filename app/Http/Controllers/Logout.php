<?php

namespace App\Http\Controllers;

use App\Traits\AuthTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class Logout extends Controller
{
    use AuthTrait;
    public function __invoke(Request $request)
    {
        $currentToken = $request->bearerToken();
        if ($currentToken) {
            Auth::user()->currentAccessToken()->delete();
        } else {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return response()->success('logged out');
    }
}
