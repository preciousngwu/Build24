<?php

namespace App\Http\Controllers;

use App\Traits\AuthTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    use AuthTrait;

    public function __construct(protected Request $request)
    {
        $request->validate([
            "email"    => "required|email",
            "password" => "required",
            "is_admin" => "boolean",
        ]);
    }

    public function __invoke()
    {
        $auth = ['email', 'password'];
        if ($this->request->is_admin) {
            $auth['is_admin'] = true;
        }
        return Auth::attempt($this->request->only($auth)) ? response()->success($this->createToken(Auth::user(), 'user')) : response()->failed('email or password not correct');
    }
}
