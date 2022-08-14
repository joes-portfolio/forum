<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class, 'channel_id');
    }
}
