<?php

namespace App\Actions\User;

use App\Enums\AccountEnums;
use App\Interfaces\ApiRouteInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Index implements ApiRouteInterface
{

    public function __construct(protected Request $req)
    {
        $req->validate([
            "account" => Rule::in(['student', 'admin']),
        ]);
    }
    public function do()
    {
        $accounts = [0, 1, 2];
        if ($this->req->has('account')) {
            $account  = request()->account;
            $account  = constant("\App\Enums\AccountEnums::$account");
            $accounts = [$account->value, AccountEnums::both->value];
        }
        return response()->success(User::whereIn('account', $accounts)->with(['resource' => function ($query) {
            $query->where("title", "avatar");
        }, 'latestAuthentication' => function ($query) {
            $query->where("login_successful", true);
        }])->paginate());
    }
}
