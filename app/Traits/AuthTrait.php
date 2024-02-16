<?php

namespace App\Traits;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait AuthTrait
{
    public function createToken(Authenticatable $user, string $name, array $ability = ['*'])
    {
        return [
            'user'  => $user,
            'token' => $user->createToken($name, $ability)->plainTextToken,
        ];
    }

    public function createVerifiableToken(String | User | Authenticatable $user, $length = 5)
    {
        $email = !is_string($user) ? $user->email : $user;

        DB::table('tokens')->where('email', $email)->delete();

        $token = Str::random($length);

        DB::table('tokens')->insert([
            'email'      => $email,
            "token"      => $token,
            "created_at" => Carbon::now(),
        ]);

        return $token;
    }

    public function verifyVerifiableToken(string $token, string $email, $reset = false): Bool
    {
        $fetched = DB::table('tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$fetched) {
            throw new \Exception('invalid token');
        }

        if (Carbon::createFromTimeString($fetched->created_at)->diffInMinutes(now()) >= 50) {
            throw new \Exception('token expired');
        }

        if ($token != $fetched->token) {
            throw new \Exception('token mis-matched');
        }

        if ($reset) {
            $fetched = DB::table('tokens')->where('email', $email)
                ->where('token', $token)
                ->delete();
        }
        return true;
    }
}
