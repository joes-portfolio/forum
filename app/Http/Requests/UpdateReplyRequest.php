<?php

namespace App\Http\Requests;

use App\Rules\SpamFreeRule;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateReplyRequest extends FormRequest
{

    public function authorize(): Response
    {
        return Gate::authorize('update', $this->route('reply'));
    }

    public function rules(): array
    {
        return [
            'body' => ['required', new SpamFreeRule]
        ];
    }
}
