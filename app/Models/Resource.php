<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Resource extends Authenticatable
{

    protected $fillable = ['title', 'type', 'link', 'alt'];

    public function resourceable(): MorphTo
    {
        return $this->morphTo();
    }
}
