<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'          => $this->name,
            'path'          => $this->path,
            'url'           => Storage::disk('public')->url($this->path),
            'size'          => $this->size,
            'friendly_size' => $this->sizeName,
            'type'          => $this->type,
            'uuid'          => $this->uuid,
            'updated_at'    => $this->updated_at,
            'created_at'    => $this->created_at,
        ];
    }
}
