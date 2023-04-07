<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommonResource extends JsonResource
{
    public static $wrap = 'data';

    public function with(Request $request): array
    {
        return [
            'success' => 1,
            'error'   => null,
            'errors'  => [],
            'extra'   => [],
        ];
    }
}
