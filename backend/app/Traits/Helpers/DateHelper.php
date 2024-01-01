<?php

namespace App\Traits\Helpers;

use Carbon\Carbon;
use DateTime;

Trait DateHelper
{
    public function calculateDuration(string $start, string $end, string $format): string
    {
        $startCarbon = Carbon::parse($start);
        $endCarbon = Carbon::parse($end);

        $duration = $startCarbon->diff($endCarbon);
        return $duration->format($format);
    }

    public function calculateDurationForHumans(DateTime $start, DateTime $end): string
    {
        return Carbon::parse($end)->shortAbsoluteDiffForHumans($start, 2);
    }
}
