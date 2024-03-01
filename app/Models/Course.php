<?php

namespace App\Models;

use App\Models\Level;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Course extends Model
{
    use HasFactory;

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

}
