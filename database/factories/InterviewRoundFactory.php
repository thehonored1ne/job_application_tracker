<?php

namespace Database\Factories;

use App\Enums\RoundStatus;
use App\Enums\RoundType;
use App\Models\InterviewRound;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<InterviewRound>
 */
class InterviewRoundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = InterviewRound::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(RoundStatus::cases());

        $scheduledAt = $status === RoundStatus::Scheduled
            ? fake()->dateTimeBetween('now', '+2 weeks')
            : fake()->dateTimeBetween('-1 month', 'now');

        return [
            'job_application_id' => JobApplication::factory(),
            'round_type' => fake()->randomElement(RoundType::cases()),
            'scheduled_at' => $scheduledAt,
            'duration_minutes' => fake()->randomElement([30, 45, 60, 90]),
            'meeting_url' => fake()->randomElement([
                'https://meet.google.com/'.fake()->lexify('???-????-???'),
                'https://zoom.us/j/'.fake()->numerify('##########'),
                'https://teams.microsoft.com/l/meetup-join/'.fake()->uuid(),
            ]),
            'location' => fake()->optional(0.2)->city(),
            'interviewer_name' => fake()->name(),
            'interviewer_title' => fake()->randomElement(['Engineering Manager', 'Senior Staff Engineer', 'Talent Lead', 'VP of Engineering']),
            'interviewer_email' => fake()->safeEmail(),
            'interviewer_linkedin' => fake()->optional(0.8)->url(),
            'prep_notes' => fake()->optional(0.7)->paragraph(),
            'questions_asked' => fake()->optional(0.6)->paragraph(),
            'takeaways' => fake()->optional(0.6)->paragraph(),
            'rating' => in_array($status, [RoundStatus::Completed, RoundStatus::Passed, RoundStatus::Failed])
                ? fake()->numberBetween(1, 5)
                : null,
            'status' => $status,
        ];
    }

    /**
     * Indicate that the interview round is scheduled in the future.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => RoundStatus::Scheduled,
            'scheduled_at' => now()->addDays(rand(1, 7))->setHour(rand(9, 17))->setMinute(0),
        ]);
    }

    /**
     * Indicate that the interview round has passed successfully.
     */
    public function passed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => RoundStatus::Passed,
            'scheduled_at' => now()->subDays(rand(1, 14)),
            'rating' => fake()->numberBetween(4, 5),
        ]);
    }
}
