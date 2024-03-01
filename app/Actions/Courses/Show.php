<?php

namespace App\Actions\Courses;

use App\Interfaces\ApiRouteInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Show implements ApiRouteInterface
{
    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "id" => "required",
        ]);
    }
    public function do()
    {
        try {
            $course = Auth::user()->courses()->with(['resources', 'levels'])->firstWhere('courses.id', $this->req->id) ?? throw new \Exception('Course not found');
            return response()->success($course);
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
