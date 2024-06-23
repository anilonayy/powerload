<?php

use Illuminate\Support\Facades\Route;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | is assigned the "api" middleware group. Enjoy building your API!
// |
// */

$basePath = base_path('routes/api/');

$notWithVersions = glob("{$basePath}*.php");
$versions = glob("{$basePath}*", GLOB_ONLYDIR);

foreach ($versions as $version) {
    $files = glob("{$version}/*.php");

    foreach ($files as $file) {
        $path = basename($file, '.php');
        $version = basename(dirname($file));

        Route::prefix("{$version}/{$path}")->group($file);
    }
}

foreach ($notWithVersions as $file) {
    $path = basename($file, '.php');

    Route::prefix($path)->group($file);
}
