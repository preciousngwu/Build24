<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Tagged_level extends Pivot
{
    use HasFactory;
    protected $fillables = ['level_id', 'tagged_type'];

    public function taggedType(): Attribute
    {
        return Attribute::make(set: function ($v) {
            // if (!in_array($v, [Section::class, Lesson::class])) {
            //     throw new \Exception('invalid taggable model');
            // }
            return $v;
        });
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
