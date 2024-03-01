<?php

namespace App\Actions\User;

use App\Interfaces\ApiRouteInterface;
use App\Models\User;
use App\Traits\FuncTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Store implements ApiRouteInterface
{
    use FuncTrait;

    public function __construct(protected Request $req)
    {
        $req->validate([
            "first_name" => "required",
            "last_name"  => "required",
            "email"      => "required|email|unique:users,email",
            'country'    => "required",
            "password"   => "required",
            "account"    => ["required", Rule::in(['student', 'admin'])],
        ]);
    }

    public function do()
    {
        $account = request()->account;
        $account = constant("\App\Enums\AccountEnums::$account");

        try {
            $data             = $this->req->only(['first_name', 'last_name', 'middle_name', 'email', 'password', 'phone', 'country']);
            $data['name']     = Str::join_name($this->req->first_name, $this->req->last_name, $this->req->middle_name);
            $data['password'] = Hash::make($data['password']);
            $data['account']  = $account->value;
            $data             = User::create($data);

            return response()->success($data);
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }

    }
}
