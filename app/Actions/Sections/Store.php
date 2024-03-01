<?php

namespace App\Actions\Sections;

use App\Interfaces\ApiRouteInterface;
use App\Models\Section;
use App\Traits\FuncTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Store implements ApiRouteInterface
{
    use FuncTrait;
    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "course_id" => "required",
            "title"     => "string|required",
            "summary"   => "string",
            "levels"    => 'array',
        ]);
    }
    public function do()
    {
        try {
            $course  = Auth::user()->courses()->firstWhere('courses.id', $this->req->course_id) ?? throw new \Exception('Course not found');
            $section = $course->sections()->create($this->req->only(['title', 'summary']));

            // Sync levels
            $section->levels()->syncWithPivotValues($this->req->levels, ["tagged_type" => Section::class]);
            return response()->success($section);
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
