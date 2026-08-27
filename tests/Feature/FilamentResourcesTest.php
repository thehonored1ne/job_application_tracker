<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Enums\EmploymentType;
use App\Enums\LocationType;
use App\Enums\RoundStatus;
use App\Enums\RoundType;
use App\Filament\Pages\KanbanBoard;
use App\Filament\Resources\Companies\Pages\CreateCompany;
use App\Filament\Resources\Companies\Pages\EditCompany;
use App\Filament\Resources\Companies\Pages\ListCompanies;
use App\Filament\Resources\Companies\RelationManagers\ContactsRelationManager;
use App\Filament\Resources\Companies\RelationManagers\JobApplicationsRelationManager;
use App\Filament\Resources\Contacts\Pages\CreateContact;
use App\Filament\Resources\Contacts\Pages\EditContact;
use App\Filament\Resources\Contacts\Pages\ListContacts;
use App\Filament\Resources\JobApplications\Pages\CreateJobApplication;
use App\Filament\Resources\JobApplications\Pages\EditJobApplication;
use App\Filament\Resources\JobApplications\Pages\ListJobApplications;
use App\Filament\Resources\JobApplications\RelationManagers\InterviewRoundsRelationManager;
use App\Models\Company;
use App\Models\Contact;
use App\Models\InterviewRound;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentResourcesTest extends TestCase
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

    public function test_companies_resource_pages_render(): void
    {
        $this->actingAs($this->user);

        $company = Company::factory()->create();

        $this->get(route('filament.admin.resources.companies.index'))
            ->assertSuccessful();

        $this->get(route('filament.admin.resources.companies.create'))
            ->assertSuccessful();

        $this->get(route('filament.admin.resources.companies.edit', ['record' => $company->id]))
            ->assertSuccessful();

        Livewire::test(ListCompanies::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$company]);
    }

    public function test_can_create_and_edit_company(): void
    {
        $this->actingAs($this->user);

        Livewire::test(CreateCompany::class)
            ->fillForm([
                'name' => 'OpenAI',
                'website' => 'https://openai.com',
                'industry' => 'Artificial Intelligence',
                'location' => 'San Francisco, CA',
                'notes' => 'Pioneering generative AI.',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('companies', [
            'name' => 'OpenAI',
            'industry' => 'Artificial Intelligence',
        ]);

        $company = Company::where('name', 'OpenAI')->firstOrFail();

        Livewire::test(EditCompany::class, ['record' => $company->id])
            ->fillForm([
                'location' => 'San Francisco, CA (Hybrid)',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertEquals('San Francisco, CA (Hybrid)', $company->fresh()->location);
    }

    public function test_contacts_resource_pages_render(): void
    {
        $this->actingAs($this->user);

        $contact = Contact::factory()->create();

        $this->get(route('filament.admin.resources.contacts.index'))
            ->assertSuccessful();

        $this->get(route('filament.admin.resources.contacts.create'))
            ->assertSuccessful();

        $this->get(route('filament.admin.resources.contacts.edit', ['record' => $contact->id]))
            ->assertSuccessful();

        Livewire::test(ListContacts::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$contact]);
    }

    public function test_can_create_and_edit_contact(): void
    {
        $this->actingAs($this->user);

        $company = Company::factory()->create(['name' => 'Linear']);

        Livewire::test(CreateContact::class)
            ->fillForm([
                'company_id' => $company->id,
                'full_name' => 'Karri Saarinen',
                'role_title' => 'CEO & Co-founder',
                'email' => 'karri@linear.app',
                'linkedin_url' => 'https://linkedin.com/in/ksaarinen',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('contacts', [
            'full_name' => 'Karri Saarinen',
            'company_id' => $company->id,
        ]);

        $contact = Contact::where('full_name', 'Karri Saarinen')->firstOrFail();

        Livewire::test(EditContact::class, ['record' => $contact->id])
            ->fillForm([
                'role_title' => 'Chief Executive Officer',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertEquals('Chief Executive Officer', $contact->fresh()->role_title);
    }

    public function test_job_applications_resource_pages_render(): void
    {
        $this->actingAs($this->user);

        $app = JobApplication::factory()->create();

        $this->get(route('filament.admin.resources.job-applications.index'))
            ->assertSuccessful();

        $this->get(route('filament.admin.resources.job-applications.create'))
            ->assertSuccessful();

        $this->get(route('filament.admin.resources.job-applications.edit', ['record' => $app->id]))
            ->assertSuccessful();

        Livewire::test(ListJobApplications::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$app]);
    }

    public function test_can_create_and_edit_job_application(): void
    {
        $this->actingAs($this->user);

        $company = Company::factory()->create(['name' => 'Anthropic']);

        Livewire::test(CreateJobApplication::class)
            ->fillForm([
                'company_id' => $company->id,
                'job_title' => 'Research Engineer - Tool Use',
                'employment_type' => EmploymentType::FullTime,
                'location_type' => LocationType::Remote,
                'status' => ApplicationStatus::Applied,
                'priority_rating' => 5,
                'salary_min' => 190000,
                'salary_max' => 240000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('job_applications', [
            'job_title' => 'Research Engineer - Tool Use',
            'company_id' => $company->id,
        ]);

        $app = JobApplication::where('job_title', 'Research Engineer - Tool Use')->firstOrFail();

        Livewire::test(EditJobApplication::class, ['record' => $app->id])
            ->fillForm([
                'status' => ApplicationStatus::TechnicalInterview,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertEquals(ApplicationStatus::TechnicalInterview, $app->fresh()->status);
    }

    public function test_relation_managers_render_under_resources(): void
    {
        $this->actingAs($this->user);

        $company = Company::factory()->create();
        $contact = Contact::factory()->create(['company_id' => $company->id]);
        $app = JobApplication::factory()->create(['company_id' => $company->id]);

        Livewire::test(ContactsRelationManager::class, ['ownerRecord' => $company, 'pageClass' => EditCompany::class])
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$contact]);

        Livewire::test(JobApplicationsRelationManager::class, ['ownerRecord' => $company, 'pageClass' => EditCompany::class])
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$app]);

        $round = InterviewRound::factory()->create([
            'job_application_id' => $app->id,
            'round_type' => RoundType::Technical,
            'status' => RoundStatus::Scheduled,
        ]);

        Livewire::test(InterviewRoundsRelationManager::class, ['ownerRecord' => $app, 'pageClass' => EditJobApplication::class])
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$round]);
    }

    public function test_kanban_board_page_renders_and_updates_status(): void
    {
        $this->actingAs($this->user);

        $app = JobApplication::factory()->create([
            'status' => ApplicationStatus::Applied,
        ]);

        $this->get(route('filament.admin.pages.kanban-board'))
            ->assertSuccessful();

        Livewire::test(KanbanBoard::class)
            ->assertSuccessful()
            ->assertSee($app->job_title)
            ->call('updateApplicationStatus', $app->id, ApplicationStatus::TechnicalInterview->value);

        $this->assertEquals(ApplicationStatus::TechnicalInterview, $app->fresh()->status);
    }
}
