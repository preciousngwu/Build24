<?php

namespace App\Actions\Courses;

use App\Interfaces\ApiRouteInterface;
use Illuminate\Support\Facades\Auth;

class Index implements ApiRouteInterface
{
    public function do()
    {
        try {
            return response()->success(Auth::user()->courses()->with(['resources', 'levels'])->paginate());
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
