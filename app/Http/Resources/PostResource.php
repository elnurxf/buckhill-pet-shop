<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'       => $this->uuid,
            'title'      => $this->title,
            'slug'       => $this->slug,
            'content'    => $this->content,
            'metadata'   => $this->metadata,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
            'error'   => null,
            'errors'  => [],
            'extra'   => [],
        ];
    }
}
