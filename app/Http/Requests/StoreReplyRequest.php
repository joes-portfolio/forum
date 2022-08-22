<?php

namespace App\Http\Requests;

use App\Models\Reply;
use App\Rules\SpamFreeRule;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreReplyRequest extends FormRequest
{

    public function authorize(): Response
    {
        return Gate::authorize('create', Reply::class);
    }

    public function rules(): array
    {
        return [
            'body' => ['required', new SpamFreeRule],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated($key, $default), [
            'user_id' => auth()->id(),
        ]);
    }
}
