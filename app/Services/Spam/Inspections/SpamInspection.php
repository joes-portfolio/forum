<?php

namespace App\Services\Spam\Inspections;

interface SpamInspection
{
    public function detect(string $text);
}
