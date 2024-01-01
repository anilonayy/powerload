<?php

namespace App\Http\Resources\TrainingLogs;

use App\Traits\Helpers\ConvertHelper;
use App\Traits\Helpers\DateHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingLogWithDetail extends JsonResource
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
            'training' => [
                'id' => $this->training->id,
                'name' => $this->training->name,
                'training_day_name' => $this->trainingDay->name,
            ],
            'duration' => $this->calculateDurationForHumans($this->created_at, $this->training_end_time),
            'training_date' => Carbon::parse($this->created_at)->format('d F Y'),
            'exercises'=> $this->trainingList

        ];
    }
}
