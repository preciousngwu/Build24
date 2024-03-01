<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ["course_id", "title", "summary", "extras"];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Get all of the levels attached to sections.
     */
    public function levels(): BelongsToMany
    {
        return $this->belongsToMany(Level::class, "tagged_levels", 'tagged_id')->using(Tagged_level::class);
    }

    public function extras(): Attribute
    {
        return Attribute::make(set: function ($v) {
            return json_encode(!is_array($v) ? (array) $v : $v);
        },
            get: function ($v) {
                $v = json_decode($v);
                return !is_array($v) ? (array) $v : $v;
            });
    }
}
