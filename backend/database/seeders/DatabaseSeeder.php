<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\ExerciseCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $exerciseCategories = require_once base_path('resources/ExerciseCategories.php');
        $exercises = require_once base_path('resources/Exercises.php');

        foreach ($exerciseCategories as $category) {
            ExerciseCategory::factory()->forCategory($category)->create();
        }

        foreach ($exercises as $exerciseArray) {
            Exercise::factory()->forExercise($exerciseArray)->create();
        }

        User::factory()->create();
    }
}
