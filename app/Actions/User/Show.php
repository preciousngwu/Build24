<?php

namespace App\Actions\User;

use App\Interfaces\ApiRouteInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Show implements ApiRouteInterface
{

    public function __construct(protected Request $request)
    {
        $request->validate([
            "id" => "integer",
        ]);
    }

    public function do()
    {
        /***
         * Find user
         * Omitting user id from gets current user.
         */
        try {
            $user = $this->request->has('id') ? User::where('id', $this->request->id)->firstOr(function () {throw new \Exception("user not found");}) : Auth::user();
            return response()->success($user->load('resource'));
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }

    }
}
