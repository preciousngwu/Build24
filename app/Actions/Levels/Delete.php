<?php

namespace App\Actions\Levels;

use App\Interfaces\ApiRouteInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Delete implements ApiRouteInterface
{
    public function __construct(protected Request $req)
    {
        $this->req->validate([
            "level_id" => "required|integer",
        ]);
    }
    public function do()
    {
        try {
            $status = Auth::user()->levels()->where('levels.id', $this->req->level_id)->delete();
            return response()->success($status ? 'deleted succesfully' : 'not found');
        } catch (\Exception $e) {
            return response()->failed($e->getMessage());
        }
    }
}
