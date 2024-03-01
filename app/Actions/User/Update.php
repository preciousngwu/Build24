<?php

namespace App\Actions\User;

use App\Enums\ResourceTypeEnums;
use App\Interfaces\ApiRouteInterface;
use App\Models\User;
use App\Traits\FuncTrait;
use Illuminate\Http\Request;

class Update implements ApiRouteInterface
{
    use FuncTrait;
    public function __construct(protected Request $request)
    {
        $request->validate([
            "user_id" => "required",
            "status"  => 'boolean',
            "name"    => "string",
            "email"   => "email",
            "phone"   => "",
            "avatar"  => "file",
        ]);
    }
    public function do()
    {
        try {
            $user = User::find($this->request->user_id);
            if (!$user) {
                return response()->failed("user not found");
            }

            if ($this->request->hasFile("avatar")) {
                $file = $this->uploadMedia("avatar", "images/avatar");

                $image = $user->resource()->where('title', "avatar")->firstOr(function () use ($user, $file) {
                    $user->resource()->create([
                        'title' => "avatar",
                        "type"  => ResourceTypeEnums::image->value,
                        "link"  => asset("storage$file"
                        )]);
                });

                if ($image) {
                    $image->link = asset("storage$file");
                    $image->save();
                }
            }

            $data = $this->request->only(['status', 'name']);

            $user->update($data);
            return response()->success("user profile updated");

        } catch (\Exception $e) {

            // Delete stores images on failue
            if (isset($file)) {
                $this->deleteImage($file);
            }
            return response()->failed($e->getMessage());
        }
    }
}
