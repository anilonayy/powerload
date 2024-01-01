<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

/**
 * Class RouteHelper
 * @package App\Helpers
 */
class RouteHelper
{
    /**
     * @return void
     */
    public static function setDynamicRoutes(): void
    {
        $basePath = base_path('routes/api/');
        $files = glob("{$basePath}*.php");

        foreach ($files as $file) {
            $path = basename($file, '.php');

            Route::prefix($path)->group($file);
        }
    }
}
