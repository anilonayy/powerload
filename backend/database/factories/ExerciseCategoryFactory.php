<?php
namespace Database\Factories;

use App\Models\ExerciseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExerciseCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word, // Farklı isimler almak için unique() kullanabilirsiniz.
        ];
    }

    /**
     * Define a specific category state.
     *
     * @param string $category
     * @return ExerciseCategoryFactory
     */
    public function forCategory(string $category)
    {
        return $this->state(function (array $attributes) use ($category) {
            return [
                'name' => $category,
            ];
        });
    }
}
