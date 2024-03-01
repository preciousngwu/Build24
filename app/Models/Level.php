<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'benefits'];

    public function benefits(): Attribute
    {
        return Attribute::make(set: fn($v) => json_encode($v), get: fn($v) => json_decode($v));
    }
}
