<?php

namespace App\Actions\Levels;

use App\Interfaces\ApiRouteInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Store implements ApiRouteInterface
{

    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "title"      => "string|required",
            "benefits"   => "array",
            "benefits.*" => 'string',
            "course_id"  => 'required|integer',
        ]);
    }
    public function do()
    {
        try {
            $course = Auth::user()->courses()->firstWhere('courses.id', $this->req->course_id) ?? throw new \Exception("Course not found");
            $level  = $course->levels()->create($this->req->only(['title', 'benefits']));
            return response()->success($level);
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
