<?php

namespace App\Http\Controllers;

use App\Traits\AuthTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    use AuthTrait;

    public function __construct(protected Request $req)
    {
        $req->validate([
            "email"    => "required|email",
            "password" => "required",
            "account"  => "boolean",
        ]);
    }

    public function __invoke()
    {
        if (Auth::attempt([
            'email'            => $this->req->email,
            'password'         => $this->req->password,
            fn(Builder $query) => $query->where('account', $this->req->account)->orWhere('account', 2),
        ])) {
            return response()->success($this->createToken(Auth::user(), 'user'));
        }
        return response()->failed('email or password not correct');
    }
}
