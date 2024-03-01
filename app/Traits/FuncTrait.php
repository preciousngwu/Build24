<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FuncTrait
{
    public static function uploadMedia($name, $storeAt = null)
    {
        $name = Str::of($name);

        if (!request()->hasFile($name) || empty(request()->{$name})) {
            throw new \Exception("file empty");
        }
        $ext = request()
            ->$name
            ->getClientOriginalExtension();

        $file = request()
            ->file($name)
            ->storeAs($storeAt ?? $name, $name->append(Str::uuid()->toString(), '.', $ext), env('FILESYSTEM_DISK'));

        return '/' . $file;
    }

    public function uploadMediaFile($name, $file, $storeAt = null)
    {
        $name = Str::of($name);
        $file = $file->storeAs($storeAt ?? $name, $name->append(Str::uuid()->toString(), '.', $file->getClientOriginalExtension()), env('FILESYSTEM_DISK'));
        return '/' . $file;
    }

    public static function deleteImage(array | string $paths)
    {
        Storage::disk('public')->delete($paths);
    }

    public function saveResource($name, Model $model)
    {
        if (!$this->req->hasFile($name)) {
            return false;
        }
        $object = $this->req->file($name);
        $file   = $this->uploadMediaFile($name, $object, "resource/" . $name);
        $image  = $model->resources()->where('title', $name)->first();
        if ($image) {
            $image->alt  = $object->getClientOriginalName();
            $image->link = asset("storage$file");
            $image->save();
        } else {
            $model->resources()->create([
                'title' => $name,
                'alt'   => $object->getClientOriginalName(),
                "type"  => $object->getMimeType(),
                "link"  => asset("storage$file"),
            ]);
        }
        return $file;
    }

}
