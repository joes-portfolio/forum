<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorite extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'user_id',
    ];

    public function favorited(): MorphTo
    {
        return $this->morphTo();
    }
}
