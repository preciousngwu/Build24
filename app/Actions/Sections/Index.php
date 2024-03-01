<?php

namespace App\Actions\Sections;

use App\Interfaces\ApiRouteInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Index implements ApiRouteInterface
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
            return response()->success(Auth::user()->sections()->where('sections.course_id', $this->req->course_id)->with(['lessons', 'levels'])->orderBy('sections.id', 'DESC')->get());
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
