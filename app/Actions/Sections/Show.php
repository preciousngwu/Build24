<?php

namespace App\Actions\Sections;

use App\Interfaces\ApiRouteInterface;
use App\Traits\FuncTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Show implements ApiRouteInterface
{
    use FuncTrait;
    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "id" => "required",
        ]);
    }
    public function do()
    {
        try {
            return response()->success(Auth::user()->sections()->with(['levels'])->firstWhere('sections.id', $this->req->id) ?? throw new \Exception('Section not found'));
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
