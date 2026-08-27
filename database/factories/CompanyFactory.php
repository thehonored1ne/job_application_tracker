<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'website' => fake()->optional(0.8)->url(),
            'logo_path' => null,
            'industry' => fake()->randomElement(['Fintech', 'SaaS', 'Healthtech', 'E-commerce', 'AI / ML', 'Cybersecurity', 'EdTech']),
            'location' => fake()->city().', '.fake()->country(),
            'notes' => fake()->optional(0.6)->paragraph(),
        ];
    }
}
