<?php

namespace App\Http\Resources\WorkoutLogs;

use App\Traits\Helpers\ConvertHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutLogs extends JsonResource
{
    protected $collects = \App\Models\WorkoutLogs::class;

    use ConvertHelper;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = json_decode(json_encode($this->resource), false);

        return [
            'id'     => $data->id,
            'status' => [
                'code' => $data->status,
                'text' => $this->convertLogStatusToText($data->status),
            ],
            'workout' => [
                'id'   => $data->workout->id,
                'name' => $data->workout->name,
            ],
            'workout_day' => [
                'id'   => $data->workout_day->id,
                'name' => $data->workout_day->name,
            ],
            'duration'       => Carbon::parse($data->workout_end_time)->diff($data->created_at),
            'workout_date'   => $data->created_at,
            'completed_date' => Carbon::parse(Carbon::parse(time()))->diff($data->workout_end_time),
        ];
    }
}
