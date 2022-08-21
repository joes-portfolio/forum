<?php

namespace App\Services\Spam\Inspections;

class InvalidKeyWords implements SpamInspection
{
    protected $invalidKeyWords = [
        'Earn extra cash',
        'Double your cash',
        'Financial freedom',
    ];

    public function detect(string $text)
    {
        foreach ($this->invalidKeyWords as $invalidKeyWord) {
            if (stripos($text, $invalidKeyWord) !== false) {
                throw new \Exception("Don't be a spammer. Be better.");
            }
        }
    }
}
