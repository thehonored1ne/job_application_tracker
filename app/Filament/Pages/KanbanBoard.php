<?php

namespace App\Filament\Pages;

use App\Enums\ApplicationStatus;
use App\Models\Company;
use App\Models\JobApplication;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Collection;
use UnitEnum;

class KanbanBoard extends Page
{
    protected string $view = 'filament.pages.kanban-board';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-view-columns';

    protected static UnitEnum|string|null $navigationGroup = 'CRM & Network';

    protected static ?string $navigationLabel = 'Pipeline Kanban';

    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'Application Pipeline Kanban';

    public string $search = '';

    public ?int $selectedCompanyId = null;

    public ?int $minPriority = null;

    public string $stageGroup = 'all'; // 'all', 'active', 'interviewing', 'closed'

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    public function updateApplicationStatus(int $applicationId, string $newStatus): void
    {
        $statusEnum = ApplicationStatus::tryFrom($newStatus);

        if (! $statusEnum) {
            Notification::make()
                ->title('Invalid status stage')
                ->danger()
                ->send();

            return;
        }

        $application = JobApplication::find($applicationId);

        if (! $application) {
            Notification::make()
                ->title('Application not found')
                ->danger()
                ->send();

            return;
        }

        $application->update(['status' => $statusEnum]);

        Notification::make()
            ->title("Moved {$application->job_title} to {$statusEnum->getLabel()}")
            ->success()
            ->send();
    }

    /**
     * @return array<string, array{status: ApplicationStatus, label: string, color: string, icon: string, items: Collection}>
     */
    public function getColumnsProperty(): array
    {
        $allStatuses = ApplicationStatus::cases();

        // Filter statuses based on selected stageGroup
        $statuses = match ($this->stageGroup) {
            'active' => [
                ApplicationStatus::Wishlist,
                ApplicationStatus::Applied,
                ApplicationStatus::Screening,
                ApplicationStatus::TechnicalInterview,
                ApplicationStatus::BehavioralInterview,
                ApplicationStatus::FinalRound,
                ApplicationStatus::OfferReceived,
            ],
            'interviewing' => [
                ApplicationStatus::Screening,
                ApplicationStatus::TechnicalInterview,
                ApplicationStatus::BehavioralInterview,
                ApplicationStatus::FinalRound,
            ],
            'closed' => [
                ApplicationStatus::OfferReceived,
                ApplicationStatus::Accepted,
                ApplicationStatus::Rejected,
                ApplicationStatus::Withdrawn,
            ],
            default => $allStatuses,
        };

        $query = JobApplication::query()
            ->with(['company', 'contact', 'interviewRounds' => fn ($q) => $q->upcoming()])
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('job_title', 'like', "%{$this->search}%")
                        ->orWhereHas('company', fn ($c) => $c->where('name', 'like', "%{$this->search}%"));
                });
            })
            ->when($this->selectedCompanyId, fn ($q) => $q->where('company_id', $this->selectedCompanyId))
            ->when($this->minPriority, fn ($q) => $q->where('priority_rating', '>=', $this->minPriority))
            ->orderByDesc('priority_rating')
            ->orderByDesc('applied_date');

        $allApplications = $query->get()->groupBy(fn ($app) => $app->status->value);

        $columns = [];
        foreach ($statuses as $status) {
            $columns[$status->value] = [
                'status' => $status,
                'label' => $status->getLabel(),
                'color' => $status->getColor(),
                'icon' => $status->getIcon(),
                'items' => $allApplications->get($status->value, collect()),
            ];
        }

        return $columns;
    }

    public function getCompaniesProperty(): Collection
    {
        return Company::orderBy('name')->get();
    }
}
