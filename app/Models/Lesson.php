<?php

namespace App\Models;

use App\Models\Level;
use App\Models\Resource;
use App\Models\Tagged_level;
use App\Traits\SimilarMutateTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    use HasFactory, SimilarMutateTraits;

    protected $fillable = ["section_id", "title", "summary", "type", "content", 'extras'];
    protected $with     = ['levels'];

    public function resources(): MorphMany
    {
        return $this->morphMany(Resource::class, "resourceable");
    }

    public function content(): Attribute
    {
        return Attribute::make(set: fn($v) => json_encode($v), get: fn($v) => json_decode($v) ?? (object) []);
    }

        /**
     * Get all of the tags for the post.
     */
    public function levels(): MorphToMany
    {
        return $this->morphToMany(Level::class, 'tagged', 'tagged_levels');
    }


    // /**
    //  * Get all of the levels attached to lessons.‰
    //  */
    // public function levels(): BelongsToMany
    // {
    //     return $this->belongsToMany(Level::class, "tagged_levels", 'tagged_id')->where("tagged_type", Lesson::class)->using(Tagged_level::class);
    // }
}
