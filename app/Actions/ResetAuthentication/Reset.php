<?php

namespace App\Actions\ResetAuthentication;

use App\Interfaces\ApiRouteInterface;
use App\Models\User;
use App\Traits\AuthTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Reset implements ApiRouteInterface
{
    use AuthTrait;
    public function __construct(protected Request $request)
    {
        $request->validate([
            "token"    => "required",
            "holder"   => "required",
            "email"    => "sometimes|required|email",
            "password" => "required|confirmed",
            "type"     => "reqiured"
        ]);
    }

    public function do()
    {

        try {
            DB::beginTransaction();

            // Verify token to proceed
            $this->verifyVerifiableToken($this->request->token, $this->request->holder, true);

            // Get reset account holder
            $user = User::where('email', $this->request->holder)->first() ?? throw new \Exception('user not found');

            $user->email = $this->request->email ?? $user->email;

            if ($user->password = "password") {
                $user->password = Hash::make($this->request->password);
            }
            $user->save();

            if ($this->request->type == "email") {
                if (!Auth::attempt(["email" => $user->email, "password" => $this->request->password])) {
                    throw new \Exception('Incorrect password or email');
                }
                $this->createToken(Auth::user(), 'user');
            }

            DB::commit();

            return response()->success("Reset was successfull");
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }

    }
}
