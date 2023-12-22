<?php

namespace Database\Factories;

use App\Models\Travel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Travel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(20),
            'is_public'=> $this->faker->boolean,
            'description'=> $this->faker->text(100),
            'number_of_days'=> rand(1,10),
        ];
    }
}
