<?php

namespace App\Actions\Levels;

use App\Interfaces\ApiRouteInterface;
use Illuminate\Support\Facades\Auth;

class Index implements ApiRouteInterface
{
    public function do()
    {
        try {
            return response()->success(Auth::user()->levels()->get());
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
