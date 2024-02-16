<?php

namespace App\Actions\ResetAuthentication;

use App\Interfaces\ApiRouteInterface;
use App\Traits\AuthTrait;
use Illuminate\Http\Request;

class Verify_token implements ApiRouteInterface
{
    use AuthTrait;
    public function __construct(protected Request $request)
    {
        $request->validate([
            "token" => "required",
            "email" => "required",
        ]);
    }

    public function do()
    {
        try {
            $this->verifyVerifiableToken($this->request->token, $this->request->email);
            return response()->success('token verified');
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
