<?php

namespace App\Actions\ResetAuthentication;

use App\Interfaces\ApiRouteInterface;
use App\Models\User;
use App\Notifications\ResetAuthNotification;
use App\Traits\AuthTrait;
use Illuminate\Http\Request;

class Send_token implements ApiRouteInterface
{
    use AuthTrait;
    public function __construct(protected Request $request)
    {
        $request->validate([
            "email" => "required",
        ]);
    }

    public function do()
    {
        try {
            $user = User::where('email', $this->request->email)->first() ?? throw new \Exception('user not found');

            $token   = $this->createVerifiableToken($user, 10);
            $payload = [
                'token' => $token,
                "type"  => $this->request->type,
                "email" => $this->request->email,
                "name"  => $user->name,
                "url"   => env("WEB_URL") . "/reset/" . $this->request->type . "?token=" . $token . "&email=" . $this->request->email,
            ];

            $user->notify(new ResetAuthNotification($payload));
            return response()->success('Sent successfully');

        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
