<?php

namespace App\Services\Spam\Inspections;

class KeyHeldDown implements SpamInspection
{
    public function detect(string $text)
    {
        if (preg_match('/(.)\\1{3,}/', $text)) {
            throw new \Exception("Don't be a spammer. Be better.");
        }
    }
}
