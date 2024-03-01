<?php

namespace App\Models;

use App\Models\Level;
use App\Models\Resource;
use App\Models\Tagged_level;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ["title", "summary", "type", "content"];

    public function resource(): MorphOne
    {
        return $this->morphOne(Resource::class, "resourceable");
    }

    public function content(): Attribute
    {
        return Attribute::make(set: fn($v) => json_encode($v), get: fn($v) => json_decode($v));
    }

    /**
     * Get all of the levels attached to lessons.
     */
    public function levels(): BelongsToMany
    {
        return $this->belongsToMany(Level::class, "tagged_levels", 'tagged_id')->using(Tagged_level::class);
    }
}
