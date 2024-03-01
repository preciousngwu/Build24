<?php

namespace App\Actions\Courses;

use App\Interfaces\ApiRouteInterface;
use App\Traits\FuncTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Update implements ApiRouteInterface
{
    use FuncTrait;
    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "id"          => "required",
            "title"       => "string",
            "cover"       => "file",
            "overview"    => "file",
            "teaser"      => "file",
            "signup_link" => "without_spaces|string|unique:courses,signup_link",
            "summary"     => "string",
            "levels"      => "array",
        ], [
            "without_spaces" => ":attribute must not contain spaces",
        ]);
    }
    public function do()
    {
        try {
            DB::beginTransaction();
            $course = Auth::user()->courses()->firstWhere('courses.id', $this->req->id) ?? throw new \Exception('Course not found');
            $course->update($this->req->only(['title', 'summary', 'signup_link']));

            $files = [];
            if ($this->req->has('cover')) {
                $files[] = $this->saveResource('cover', $course);
            }
            if ($this->req->has('overview')) {
                $files[] = $this->saveResource('overview', $course);
            }
            if ($this->req->has('teaser')) {
                $files[] = $this->saveResource('teaser', $course);
            }
            DB::commit();
            return response()->success("updated successfully");
        } catch (\Exception $e) {
            if (!empty($files)) {
                FuncTrait::deleteImage($files);
            }
            return response()->failed($e->getMessage());
        }
    }

}
