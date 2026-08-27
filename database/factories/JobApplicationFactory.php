<?php

namespace Database\Factories;

use App\Enums\ApplicationStatus;
use App\Enums\EmploymentType;
use App\Enums\LocationType;
use App\Enums\SalaryPeriod;
use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<JobApplication>
 */
class JobApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = JobApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $minSalary = fake()->numberBetween(60, 160) * 1000;
        $maxSalary = $minSalary + fake()->numberBetween(15, 50) * 1000;
        $status = fake()->randomElement(ApplicationStatus::cases());

        $appliedDate = $status === ApplicationStatus::Wishlist
            ? null
            : fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d');

        return [
            'company_id' => Company::factory(),
            'contact_id' => null,
            'job_title' => fake()->randomElement([
                'Senior Laravel Developer',
                'Full Stack PHP / Vue Engineer',
                'Lead Backend Engineer',
                'Software Architect',
                'Principal Engineer',
                'DevOps & Cloud Engineer',
            ]),
            'job_url' => fake()->optional(0.8)->url(),
            'description' => fake()->paragraphs(3, true),
            'employment_type' => fake()->randomElement(EmploymentType::cases()),
            'location_type' => fake()->randomElement(LocationType::cases()),
            'location' => fake()->city().', '.fake()->country(),
            'salary_min' => $minSalary,
            'salary_max' => $maxSalary,
            'salary_offered' => $status === ApplicationStatus::OfferReceived || $status === ApplicationStatus::Accepted
                ? $maxSalary
                : null,
            'currency' => 'USD',
            'salary_period' => SalaryPeriod::Yearly,
            'status' => $status,
            'priority_rating' => fake()->numberBetween(1, 5),
            'applied_date' => $appliedDate,
            'deadline_date' => fake()->optional(0.4)->dateTimeBetween('now', '+1 month')?->format('Y-m-d'),
            'decision_date' => in_array($status, [ApplicationStatus::OfferReceived, ApplicationStatus::Accepted, ApplicationStatus::Rejected])
                ? fake()->dateTimeBetween('-2 weeks', 'now')->format('Y-m-d')
                : null,
            'notes' => fake()->optional(0.6)->paragraph(),
        ];
    }

    /**
     * Indicate that the application is in wishlist stage.
     */
    public function wishlist(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ApplicationStatus::Wishlist,
            'applied_date' => null,
        ]);
    }

    /**
     * Indicate that the application has been submitted.
     */
    public function applied(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ApplicationStatus::Applied,
            'applied_date' => now()->subDays(rand(1, 14))->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the application is in an active interview stage.
     */
    public function interviewing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => fake()->randomElement([
                ApplicationStatus::Screening,
                ApplicationStatus::TechnicalInterview,
                ApplicationStatus::BehavioralInterview,
                ApplicationStatus::FinalRound,
            ]),
            'applied_date' => now()->subDays(rand(7, 30))->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the application has received an offer.
     */
    public function offerReceived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ApplicationStatus::OfferReceived,
            'applied_date' => now()->subDays(rand(20, 45))->format('Y-m-d'),
            'salary_offered' => $attributes['salary_max'] ?? 140000.00,
            'decision_date' => now()->subDays(rand(1, 5))->format('Y-m-d'),
        ]);
    }
}
