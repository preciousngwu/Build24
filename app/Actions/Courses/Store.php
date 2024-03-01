<?php

namespace App\Actions\Courses;

use App\Enums\ResourceTypeEnums;
use App\Interfaces\ApiRouteInterface;
use App\Traits\FuncTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Store implements ApiRouteInterface
{
    use FuncTrait;
    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "title"       => "required",
            "cover"       => "file",
            "signup_link" => "without_spaces|required|string|unique:courses,signup_link",
            "summary"     => "string|required",
        ], [
            "without_spaces" => ":attribute must not contain spaces",
        ]);
    }
    public function do()
    {
        try {
            DB::beginTransaction();
            $toStore = $this->req->only(['title', 'summary', 'signup_link']);
            $course  = Auth::user()->courses()->create($toStore);

            if ($this->req->hasFile("cover")) {
                $file = $this->uploadMedia("cover", "images/cover");
                $course->resources()->create([
                    'title' => "cover",
                    'alt'   => $this->req->cover->getClientOriginalName(),
                    "type"  => ResourceTypeEnums::image->value,
                    "link"  => asset("storage$file"),
                ]);
            }
            DB::commit();
            return response()->success($course);
        } catch (\Exception $e) {
            // Delete stores images on failue
            if (isset($file)) {
                $this->deleteImage($file);
            }
            return response()->failed($e->getMessage());
        }
    }
}
