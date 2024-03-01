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
            "course_id"      => "required",
            'section_levels' => 'array',
            // "updates"          => "array:id,,lessons",
            // "updates.*id"      => "required",
            // "updates.*lessons" => "array",
        ]);
    }
    public function do()
    {
        try {
            DB::beginTransaction();
            $course = Auth::user()->courses()->firstWhere('id', $this->req->course_id) ?? throw new \Exception('course not found');
            foreach ($this->req->updates as $v) {
                $sectionData = collect($v)->except(['lessons', 'course_id', 'section_levels'])->toArray();
                if (isset($v['id'])) {
                    $section = $course->sections()->where('sections.id', $v['id'])->first();
                    if ($section) {
                        $section->update($sectionData);
                        if (isset($v['section_levels'])) {
                            $section->levels()->syncWithPivotValues($v['section_levels'], ["tagged_type" => Section::class]);
                        }
                    }
                } else {
                    $section = $course->sections()->create($sectionData);
                    if (isset($v['section_levels'])) {
                        $section->levels()->syncWithPivotValues($v['section_levels'], ["tagged_type" => Section::class]);
                    }
                }
            }
            DB::commit();
            return response()->success($this->req->updates);
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
