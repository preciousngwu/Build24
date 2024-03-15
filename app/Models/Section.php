<?php

namespace App\Models;

use App\Models\Level;
use App\Traits\SimilarMutateTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Section extends Model
{
    use HasFactory, SimilarMutateTraits;
    protected $fillable = ["course_id", "title", "summary", "extras"];
    protected $hidden = ['pivot'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Get all of the levels attached to sections.
     */
    // public function levels(): BelongsToMany
    // {
    //     return $this->belongsToMany(Level::class, "tagged_levels", 'tagged_id')->where("tagged_type", Section::class)->using(Tagged_level::class);
    // }

    /**
     * Get all of the tags for the post.
     */
    public function levels(): MorphToMany
    {
        return $this->morphToMany(Level::class, 'tagged', 'tagged_levels');
    }

}
