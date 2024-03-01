<?php
namespace App\Traits;

use App\Enums\ResourceTypeEnums;
use App\Models\Lesson;
use App\Traits\FuncTrait;
use Illuminate\Support\Facades\Validator;

trait LessonTrait
{
    public $standard = [
        "title"       => "",
        "description" => "",
        "snap_notes"  => false,
    ];

    public function standard(Lesson $lesson, array $array = [])
    {
        try {
            Validator::validate($array, [
                "src"         => "file",
                "title"       => "required|string",
                'description' => 'string',
                "snap_notes"  => 'boolean',
            ]);

            if (isset($array['src'])) {
                $file  = FuncTrait::uploadMedia("content.src", "images/lesson");
                $video = $lesson->resource()->where('title', "lesson")->firstOr(function () use ($lesson, $file) {
                    $lesson->resource()->create([
                        'title' => "lesson",
                        "type"  => ResourceTypeEnums::video->value,
                        "link"  => asset("storage$file"),
                    ]);
                });
                if ($video) {
                    $video->link = asset("storage$file");
                    $video->save();
                }
            }
            $lesson->content = collect($array)->intersectByKeys($this->standard);
            $lesson->save();

            // Return content
            return $lesson->content;
        } catch (\Exception $e) {
            // Delete stores images on failue
            if (isset($file)) {
                $this->deleteImage($file);
            }
            throw new \Exception($e->getMessage());
        }
    }
}
