<?php

namespace App\Rules;

use App\Services\Spam\Spam;
use Illuminate\Contracts\Validation\InvokableRule;

class SpamFreeRule implements InvokableRule
{
    public function __invoke($attribute, $value, $fail): void
    {
        $spam = app(Spam::class);

        try {
            $spam->detect($value);
        } catch (\Exception $e) {
            $fail('The :attribute contains spam.');
        }
    }
}
