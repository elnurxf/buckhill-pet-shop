<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PromotionResource extends CommonResource
{

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
            'content'    => $this->content,
            'metadata'   => $this->metadata,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

}
