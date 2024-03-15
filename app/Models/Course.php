<?php

namespace App\Models;

use App\Http\Controllers\Levels;
use App\Imports\LessonImports;
use App\Models\Level;
use App\Models\Resource;
use App\Traits\FuncTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;

class Course extends Model
{
    use HasFactory, FuncTrait;

    public static $parsedSheet;
    protected $fillable = ["title", "signup_link", "summary"];

    public function resources(): MorphMany
    {
        return $this->morphMany(Resource::class, "resourceable");
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    public static function getExcel(AfterSheet $event)
    {
        static::$parsedSheet = $event->getConcernable()->sheets;
    }

    public function updateManyLessons(array $data, $section = null)
    {
        foreach ($data as $key => $each) {
            $each    = collect($each)->map(fn($each) => ($this->isJson($each)))->toArray();
            $id      = ($each['section_id'] ?? $section) ?? throw new \Exception('section id not found');
            $section = $this->sections()->where('sections.id', $id)->first() ?? throw new \Exception('invalid section passed');
            $lesson  = $section->lessons()->where('lessons.id', $each['id'] ?? null)->first();

            if (isset($each['lesson_sheet']) && is_uploaded_file($each['lesson_sheet'])) {
                Excel::import(new LessonImports([Course::class, "getExcel"]), $each['lesson_sheet']);
                $each['content']->table = static::$parsedSheet;
            }

            if (!$lesson) {
                $lesson = $section->lessons()->create($each);
            } else {
                $lesson->update($each);
            }

            if (isset($each['lesson_video']) && is_uploaded_file($each['lesson_video'])) {
                $this->saveResource('lesson_video', $lesson, $each['lesson_video']);
            }

            if (isset($each['lesson_pdf']) && is_uploaded_file($each['lesson_pdf'])) {
                $this->saveResource('lesson_pdf', $lesson, $each['lesson_pdf']);
            }

            $lesson->levels()->syncWithPivotValues(collect($each['levels'])->map(fn($each) => $each->id)->toArray(), ["tagged_type" => Lesson::class]);
            $data[$key] = $lesson;
        }

        return $data;
    }
}
