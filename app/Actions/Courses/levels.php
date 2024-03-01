<?php

namespace App\Actions\Courses;

use App\Interfaces\ApiRouteInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Levels implements ApiRouteInterface
{
    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "course_id" => "required",
        ]);
    }
    public function do()
    {
        try {
            $levels = Auth::user()->levels()->where('courses.id', $this->req->course_id)->get();
            return response()->success($levels);
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
