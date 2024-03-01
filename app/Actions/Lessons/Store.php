<?php

namespace App\Actions\Lessons;

use App\Enums\LessonTypeEnums;
use App\Interfaces\ApiRouteInterface;
use App\Models\Lesson;
use App\Traits\LessonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class Store implements ApiRouteInterface
{
    use LessonTrait;
    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "section_id" => "required",
            "title"      => "string|required",
            "summary"    => "string",
            "type"       => [Rule::in(collect(LessonTypeEnums::cases())->map(fn($v) => $v->value)), "required"],
            "content"    => 'array',
            "levels"     => 'array',
        ]);
    }
    public function do()
    {
        try {
            DB::beginTransaction();
            $section = Auth::user()->sections()->firstWhere('sections.id', $this->req->section_id) ?? throw new \Exception("Section not found");
            $lesson  = $section->lessons()->create($this->req->only(["title", "summary", "type"]));

            // Save content if available
            if ($this->req->content) {
                $lesson->content = $this->{$this->req->type}($lesson, $this->req->content ?? []);
            }

            // Sync levels
            $lesson->levels()->syncWithPivotValues($this->req->levels, ["tagged_type" => Lesson::class]);

            DB::commit();
            return response()->success($lesson);
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
