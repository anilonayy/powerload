<?php

namespace App\Http\Resources\WorkoutLogs;

use App\Traits\Helpers\ConvertHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutLogWithDetail extends JsonResource
{
    use ConvertHelper;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'status' => [
                'code' => $this->status,
                'text' => $this->convertLogStatusToText($this->status),
            ],
            'workout' => [
                'id'               => $this->workout->id,
                'name'             => $this->workout->name,
                'workout_day_name' => $this->workoutDay->name,
            ],
            'duration'     => Carbon::parse($this->workout_end_time)->diff($this->created_at),
            'workout_date' => Carbon::parse($this->created_at)->format('d F Y'),
            'exercises'    => $this->workoutList,

        ];
    }
}
