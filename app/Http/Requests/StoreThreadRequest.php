<?php

namespace App\Http\Requests;

use App\Rules\SpamFreeRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreThreadRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', new SpamFreeRule],
            'body' => ['required', new SpamFreeRule],
            'channel_id' => ['required', 'exists:channels,id'],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated($key, $default), [
            'user_id' => auth()->id(),
        ]);
    }
}
