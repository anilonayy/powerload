<?php

namespace App\Http\Resources\WorkoutLogs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutLogPagination extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
//            'data' => WorkoutLogs::collection($this->resource->data),
        ];
    }
}
