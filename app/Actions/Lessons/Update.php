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

class Update implements ApiRouteInterface
{
    use LessonTrait;
    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "lesson_id" => "required",
            "title"     => "string",
            "summary"   => "string",
            "type"      => [Rule::in(collect(LessonTypeEnums::cases())->map(fn($v) => $v->value))],
            "content"   => 'array',
        ]);
    }
    public function do()
    {
        try {
            DB::beginTransaction();
            $lesson = Auth::user()->lessons()->firstWhere('lessons.id', $this->req->lesson_id);
            $lesson->update($this->req->only(["title", "summary", "type"]));

            // Save content if available
            if ($this->req->content) {
                $lesson->content = $this->{$lesson->type}($lesson, $this->req->content ?? []);
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
