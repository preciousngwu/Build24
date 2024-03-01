<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\AccountEnums;
use App\Models\Course;
use App\Models\Resource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticationLoggable, HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account',
        'phone',
        'country',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function resource(): MorphOne
    {
        return $this->morphOne(Resource::class, "resourceable");
    }

    public function createdAt(): Attribute
    {
        return Attribute::get(function ($v) {
            return Carbon::parse($v)->format("M d, Y");
        });
    }
    public function name(): Attribute
    {
        return Attribute::get(function ($v) {
            return Str::split_name($v);
        });
    }

    public function account(): Attribute
    {
        return Attribute::get(function ($v) {
            return (array) AccountEnums::byValue($v);
        });
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function sections()
    {
        return $this->hasManyThrough(Section::class, Course::class);
    }

    public function levels()
    {
        return $this->hasManyThrough(Level::class, Course::class);
    }

    public function lessons()
    {
        return $this->hasManyDeep(Lesson::class, [Course::class, Section::class]);
    }
}
