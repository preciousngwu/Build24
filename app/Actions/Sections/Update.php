<?php

namespace App\Actions\Sections;

use App\Interfaces\ApiRouteInterface;
use App\Models\Section;
use App\Traits\FuncTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Update implements ApiRouteInterface
{
    use FuncTrait;
    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "section_id"     => "required",
            "title"          => "string",
            "summary"        => "string",
            "section_levels" => 'array',
        ]);
    }
    public function do()
    {
        try {
            $section = Auth::user()->sections()->firstWhere('sections.id', $this->req->section_id) ?? throw new \Exception('Section not found');
            $section->update($this->req->only(['title', 'summary']));

            // Sync levels
            $section->levels()->syncWithPivotValues($this->req->section_levels, ["tagged_type" => Section::class]);
            return response()->success($section);
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
