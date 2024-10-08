<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'content'          => $this->content,
            'author'           => new UserResource($this->user),
            'created_at'       => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'created_at_human' => Carbon::parse($this->created_at)->diffForHumans(),
            'updated_at'       => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            'updated_at_human' => Carbon::parse($this->updated_at)->diffForHumans(),
        ];
    }
}
