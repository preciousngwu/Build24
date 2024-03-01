<?php

namespace App\Actions\Lessons;

use App\Interfaces\ApiRouteInterface;
use Illuminate\Support\Facades\Auth;

class Index implements ApiRouteInterface
{
    public function do()
    {
        try {
            return response()->success(Auth::user()->lessons()->with('resource')->paginate());
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
