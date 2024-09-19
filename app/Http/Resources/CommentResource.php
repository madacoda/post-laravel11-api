<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if(!$this->resource) {
            return [];
        }

        return [
            'id'               => $this->id,
            'comment'          => $this->comment,
            'author'           => new UserResource($this->user),
            'created_at'       => $this->created_at,
            'created_at_human' => $this->created_at->diffForHumans(),
            'updated_at'       => $this->updated_at,
            'updated_at_human' => $this->updated_at->diffForHumans(),
        ];
    }
}
