<?php

namespace App\Traits\Helpers;

trait ConvertHelper
{
    public function convertLogStatusToText(int $status): string
    {
        return match ($status) {
            0       => 'Continue',
            1       => 'Completed',
            2       => 'Give Up',
            default => 'Unknown',
        };
    }
}
