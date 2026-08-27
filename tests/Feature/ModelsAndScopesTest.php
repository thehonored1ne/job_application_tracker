<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Enums\EmploymentType;
use App\Enums\LocationType;
use App\Enums\RoundStatus;
use App\Enums\RoundType;
use App\Enums\SalaryPeriod;
use App\Models\Company;
use App\Models\Contact;
use App\Models\InterviewRound;
use App\Models\JobApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelsAndScopesTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_relationships(): void
    {
        $company = Company::factory()->create();
        $contact = Contact::factory()->create(['company_id' => $company->id]);
        $app = JobApplication::factory()->create(['company_id' => $company->id]);

        $this->assertCount(1, $company->contacts);
        $this->assertTrue($company->contacts->first()->is($contact));

        $this->assertCount(1, $company->jobApplications);
        $this->assertTrue($company->jobApplications->first()->is($app));
    }

    public function test_contact_relationships(): void
    {
        $company = Company::factory()->create();
        $contact = Contact::factory()->create(['company_id' => $company->id]);
        $app = JobApplication::factory()->create([
            'company_id' => $company->id,
            'contact_id' => $contact->id,
        ]);

        $this->assertTrue($contact->company->is($company));
        $this->assertCount(1, $contact->jobApplications);
        $this->assertTrue($contact->jobApplications->first()->is($app));
    }

    public function test_job_application_casts_and_relationships(): void
    {
        $company = Company::factory()->create();
        $contact = Contact::factory()->create(['company_id' => $company->id]);

        $app = JobApplication::factory()->create([
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'status' => ApplicationStatus::Applied,
            'employment_type' => EmploymentType::FullTime,
            'location_type' => LocationType::Remote,
            'salary_period' => SalaryPeriod::Yearly,
            'salary_min' => 120000.50,
            'priority_rating' => 4,
            'applied_date' => '2026-08-01',
        ]);

        $round = InterviewRound::factory()->create([
            'job_application_id' => $app->id,
            'round_type' => RoundType::Technical,
            'status' => RoundStatus::Scheduled,
        ]);

        $this->assertTrue($app->company->is($company));
        $this->assertTrue($app->contact->is($contact));
        $this->assertCount(1, $app->interviewRounds);
        $this->assertTrue($app->interviewRounds->first()->is($round));

        $this->assertInstanceOf(ApplicationStatus::class, $app->status);
        $this->assertInstanceOf(EmploymentType::class, $app->employment_type);
        $this->assertInstanceOf(LocationType::class, $app->location_type);
        $this->assertInstanceOf(SalaryPeriod::class, $app->salary_period);
        $this->assertEquals('120000.50', $app->salary_min);
        $this->assertEquals(4, $app->priority_rating);
    }

    public function test_job_application_scopes(): void
    {
        $wishlist = JobApplication::factory()->wishlist()->create(['priority_rating' => 2]);
        $applied = JobApplication::factory()->applied()->create(['priority_rating' => 3]);
        $screening = JobApplication::factory()->create([
            'status' => ApplicationStatus::Screening,
            'priority_rating' => 5,
        ]);
        $offer = JobApplication::factory()->offerReceived()->create(['priority_rating' => 5]);
        $rejected = JobApplication::factory()->create([
            'status' => ApplicationStatus::Rejected,
            'priority_rating' => 4,
        ]);

        // Active Interviews scope (Screening, Technical, Behavioral, Final)
        $interviewApps = JobApplication::activeInterviews()->get();
        $this->assertTrue($interviewApps->contains($screening));
        $this->assertFalse($interviewApps->contains($applied));
        $this->assertFalse($interviewApps->contains($wishlist));

        // Pending scope (Applied, Interviews, OfferReceived)
        $pendingApps = JobApplication::pending()->get();
        $this->assertTrue($pendingApps->contains($applied));
        $this->assertTrue($pendingApps->contains($screening));
        $this->assertTrue($pendingApps->contains($offer));
        $this->assertFalse($pendingApps->contains($wishlist));
        $this->assertFalse($pendingApps->contains($rejected));

        // NonWishlist scope
        $nonWishlist = JobApplication::nonWishlist()->get();
        $this->assertFalse($nonWishlist->contains($wishlist));
        $this->assertTrue($nonWishlist->contains($applied));

        // Offers scope
        $offers = JobApplication::offers()->get();
        $this->assertTrue($offers->contains($offer));
        $this->assertFalse($offers->contains($applied));

        // High priority scope
        $highPriority = JobApplication::highPriority(4)->get();
        $this->assertTrue($highPriority->contains($screening));
        $this->assertTrue($highPriority->contains($offer));
        $this->assertTrue($highPriority->contains($rejected));
        $this->assertFalse($highPriority->contains($wishlist));
    }

    public function test_interview_round_scopes_and_relationships(): void
    {
        $app = JobApplication::factory()->create();

        $upcomingRound = InterviewRound::factory()->create([
            'job_application_id' => $app->id,
            'status' => RoundStatus::Scheduled,
            'scheduled_at' => now()->addDays(2),
        ]);

        $pastCompletedRound = InterviewRound::factory()->create([
            'job_application_id' => $app->id,
            'status' => RoundStatus::Completed,
            'scheduled_at' => now()->subDays(3),
        ]);

        $passedRound = InterviewRound::factory()->create([
            'job_application_id' => $app->id,
            'status' => RoundStatus::Passed,
            'scheduled_at' => now()->subDays(5),
        ]);

        $this->assertTrue($upcomingRound->jobApplication->is($app));

        $upcoming = InterviewRound::upcoming()->get();
        $this->assertTrue($upcoming->contains($upcomingRound));
        $this->assertFalse($upcoming->contains($pastCompletedRound));

        $completed = InterviewRound::completed()->get();
        $this->assertTrue($completed->contains($pastCompletedRound));
        $this->assertTrue($completed->contains($passedRound));
        $this->assertFalse($completed->contains($upcomingRound));
    }
}
