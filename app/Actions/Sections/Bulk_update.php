<?php

namespace App\Actions\Sections;

use App\Interfaces\ApiRouteInterface;
use App\Models\Section;
use App\Traits\FuncTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Bulk_update implements ApiRouteInterface
{
    use FuncTrait;
    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "course_id" => "required",
            // 'level_ids' => 'array',
            // "updates"          => "array:id,,lessons",
            // "updates.*id"      => "required",
            // "updates.*lessons" => "array",
        ]);
    }
    public function do()
    {
        try {
            DB::beginTransaction();
            $data   = $this->req->all();
            $course = Auth::user()->courses()->firstWhere('id', $this->req->course_id) ?? throw new \Exception('course not found');
            foreach ($data['updates'] as $key => $v) {
                $v                     = collect($v)->map(fn($each) => $this->isJson($each));
                $sectionData           = $v->except(['lessons', 'course_id', 'level_ids'])->toArray();
                $data['updates'][$key] = $v->toArray();

                if (isset($v['id'])) {
                    $section = $course->sections()->where('sections.id', $v['id'])->first() ?? throw new \Exception('invalid section passed');
                    $section->update($sectionData);
                } else {
                    $section = $course->sections()->create($sectionData);
                }
                $data['updates'][$key] = collect($data['updates'][$key])->merge($section);

                if (isset($v['levels'])) {
                    $section->levels()->syncWithPivotValues(collect($v['levels'])->map(fn($v) => $v->id)->toArray(), ["tagged_type" => Section::class]);
                }
                
                if (isset($v['lessons'])) {
                    // update lessons
                    $data['updates'][$key]['lessons'] = $course->updateManyLessons($v['lessons'], $section->id);
                }
            }
            DB::commit();
            return response()->success($data);
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
