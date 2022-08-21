<?php

namespace App\Services\Spam;

use App\Services\Spam\Inspections\InvalidKeyWords;
use App\Services\Spam\Inspections\KeyHeldDown;

class Spam
{
    protected array $inspections = [
        InvalidKeyWords::class,
        KeyHeldDown::class,
    ];

    public function __construct() {}

    public function detect(string $text): bool
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($text);
        }

        return false;
    }
}
