<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path'
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
    ];

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class, 'user_id')->latest();
    }

    public function activity(): HasMany
    {
        return $this->hasMany(Activity::class, 'user_id');
    }

    public function lastReply(): HasOne
    {
        return $this->hasOne(Reply::class)->latestOfMany();
    }

    public function avatarPath(): Attribute
    {
        return Attribute::get(function ($value) {
            return $value ? "/storage/$value" : "/storage/avatars/default.png";
        });
    }

    public function visitedThreadCacheKey(Thread $thread): string
    {
        return sprintf('users.%s.visits.%s', $this->id, $thread->id);
    }

    public function read(Thread $thread): void
    {
        cache()->forever($this->visitedThreadCacheKey($thread), now());
    }
}
