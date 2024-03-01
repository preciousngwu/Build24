<?php

namespace App\Actions\Levels;

use App\Interfaces\ApiRouteInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Update implements ApiRouteInterface
{

    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "level_id"   => "required",
            "title"      => "string",
            "benefits"   => "array",
            "benefits.*" => 'string',
        ]);
    }
    public function do()
    {
        try {
            $toUpdate = $this->req->only(['title', 'benefits']);
            $level    = Auth::user()->levels()->firstWhere('levels.id', $this->req->level_id) ?? throw new \Exception('levels not found');
            $level->update($toUpdate);

            return response()->success($toUpdate);
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
