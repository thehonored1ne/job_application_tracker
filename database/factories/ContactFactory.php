<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'full_name' => fake()->name(),
            'role_title' => fake()->randomElement([
                'Technical Recruiter',
                'Senior Talent Partner',
                'Engineering Manager',
                'Head of Talent Acquisition',
                'VP of Engineering',
                'CTO',
            ]),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional(0.7)->phoneNumber(),
            'linkedin_url' => fake()->optional(0.8)->url(),
            'notes' => fake()->optional(0.5)->paragraph(),
        ];
    }
}
