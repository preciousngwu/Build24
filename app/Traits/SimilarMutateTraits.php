<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait SimilarMutateTraits
{
    public function extras(): Attribute
    {
        return Attribute::make(set: function ($v) {
            return json_encode($v);
        },
            get: function ($v) {
                return json_decode($v);
            });
    }
}
