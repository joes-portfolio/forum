<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    public function path(): string
    {
        return "/threads/{$this->id}";
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }
}
