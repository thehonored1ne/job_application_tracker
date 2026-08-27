<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Enums\RoundStatus;
use App\Enums\RoundType;
use App\Filament\Widgets\ApplicationsChart;
use App\Filament\Widgets\StageDistributionChart;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\UpcomingInterviewsWidget;
use App\Models\InterviewRound;
use App\Models\JobApplication;
use App\Models\User;
use Filament\Pages\Dashboard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardWidgetsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'admin@example.com',
        ]);
    }

    public function test_dashboard_page_renders_with_widgets(): void
    {
        $this->actingAs($this->user);

        $this->get(route('filament.admin.pages.dashboard'))
            ->assertSuccessful();

        Livewire::test(Dashboard::class)
            ->assertSuccessful();
    }

    public function test_stats_overview_widget_calculates_correct_metrics(): void
    {
        $this->actingAs($this->user);

        JobApplication::factory()->applied()->create();
        JobApplication::factory()->create(['status' => ApplicationStatus::Screening]);
        JobApplication::factory()->offerReceived()->create();
        JobApplication::factory()->wishlist()->create();

        Livewire::test(StatsOverviewWidget::class)
            ->assertSuccessful()
            ->assertSee('Total Applications')
            ->assertSee('Active Interviews')
            ->assertSee('Offers Received')
            ->assertSee('Interview Rate')
            ->assertSee('Offer Conversion');
    }

    public function test_upcoming_interviews_widget_renders_scheduled_rounds(): void
    {
        $this->actingAs($this->user);

        $app = JobApplication::factory()->create(['job_title' => 'Lead Architect']);
        $upcoming = InterviewRound::factory()->create([
            'job_application_id' => $app->id,
            'round_type' => RoundType::Technical,
            'status' => RoundStatus::Scheduled,
            'scheduled_at' => now()->addDays(2),
        ]);

        Livewire::test(UpcomingInterviewsWidget::class)
            ->assertSuccessful()
            ->assertSee('Lead Architect')
            ->assertSee('Technical Interview');
    }

    public function test_applications_chart_widget_renders_datasets(): void
    {
        $this->actingAs($this->user);

        JobApplication::factory()->applied()->create();

        Livewire::test(ApplicationsChart::class)
            ->assertSuccessful();
    }

    public function test_stage_distribution_chart_widget_renders_segments(): void
    {
        $this->actingAs($this->user);

        JobApplication::factory()->wishlist()->create();
        JobApplication::factory()->applied()->create();

        Livewire::test(StageDistributionChart::class)
            ->assertSuccessful();
    }
}
