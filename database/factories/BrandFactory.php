<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Brand::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->text,
            'logo' => $this->faker->imageUrl(),
            'website' => $this->faker->url,
            'email' => $this->faker->companyEmail
        ];
    }
}
