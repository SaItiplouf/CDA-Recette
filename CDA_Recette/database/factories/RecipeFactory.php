<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Recipe;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'preparationTime' => $this->faker->word,
            'cookingTime' => $this->faker->word,
            'serves' => $this->faker->numberBetween(-10000, 10000),
            'ingredients_id' => $this->faker->numberBetween(-100000, 100000),
        ];
    }
}
