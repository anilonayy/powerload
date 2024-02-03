<?php

namespace App\Traits\Helpers;

use Carbon\Carbon;

Trait DateHelper
{
    public function calculateDuration(string $start, string $end, string $format): string
    {
        $startCarbon = Carbon::parse($start);
        $endCarbon = Carbon::parse($end);

        $duration = $startCarbon->diff($endCarbon);
        return $duration->format($format);
    }

    public function calculateDurationForHumans(mixed $start, mixed $end, int $parts = 2): string
    {
        return Carbon::parse($end)->shortAbsoluteDiffForHumans(Carbon::parse($start), $parts);
    }
}
