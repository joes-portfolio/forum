<?php

namespace App\Http\Resources;

use App\Policies\ThreadPolicy;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Thread */
class ThreadResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'body' => $this->body,
            'created_at' => $this->created_at->diffForHumans(),
            'id' => $this->id,
            'path' => url($this->path()),
            'replies_count' => $this->replies_count,
            'title' => $this->title,

            'creator' => UserResource::make($this->whenLoaded('creator')),

            'can' => [
                ThreadPolicy::UPDATE => auth()->user()?->can(ThreadPolicy::UPDATE, $this->resource),
            ],
        ];
    }
}
