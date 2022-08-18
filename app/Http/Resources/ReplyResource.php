<?php

namespace App\Http\Resources;

use App\Policies\ReplyPolicy;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Reply */
class ReplyResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'created_at' => $this->created_at->diffForHumans(),
            'favorites_count' => $this->favorites_count,

            'owner' => UserResource::make($this->whenLoaded('owner')),

            'can' => [
                ReplyPolicy::UPDATE => auth()->user()?->can(ReplyPolicy::UPDATE, $this->resource),
            ],
        ];
    }
}
