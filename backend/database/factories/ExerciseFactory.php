<?php

namespace Database\Factories;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exercise::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
        ];
    }

    /**
     * Define a specific category state.
     *
     * @param string $category
     *
     * @return ExerciseFactory
     */
    public function forExercise(array $data)
    {
        return $this->state(function (array $attributes) use ($data) {
            return [
                'name' => $data['name'],
                'exercise_categories_id' => $data['ec'],
            ];
        });
    }
}
