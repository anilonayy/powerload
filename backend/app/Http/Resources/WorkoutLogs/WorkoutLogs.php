<?php

namespace App\Http\Resources\WorkoutLogs;

use App\Traits\Helpers\ConvertHelper;
use App\Traits\Helpers\DateHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutLogs extends JsonResource
{
    use DateHelper;
    use ConvertHelper;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'status_text' => $this->convertLogStatusToText($this->status),
            'workout' => [
                'id' => $this->workout->id,
                'name' => $this->workout->name
            ],
            'workout_day' => [
                'id' => $this->workoutDay->id,
                'name' => $this->workoutDay->name
            ],
            'duration' => $this->calculateDurationForHumans($this->created_at, $this->workout_end_time),
            'workout_date' => Carbon::parse($this->created_at)->format('d F Y'),
            'completed_date' => $this->calculateDurationForHumans($this->workout_end_time, time(), 1),
        ];
    }
}
