<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use App\Enums\ApplicationStatus;
use App\Enums\EmploymentType;
use App\Enums\LocationType;
use App\Enums\SalaryPeriod;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Role & Company')
                    ->description('Primary position details and company affiliation.')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('company_id')
                                ->label('Company')
                                ->relationship('company', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->label('Company Name')
                                        ->required(),
                                    TextInput::make('website')
                                        ->label('Website')
                                        ->url(),
                                    TextInput::make('industry')
                                        ->label('Industry'),
                                ]),
                            Select::make('contact_id')
                                ->label('Primary Recruiter / Contact')
                                ->relationship('contact', 'full_name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    TextInput::make('full_name')
                                        ->label('Contact Name')
                                        ->required(),
                                    TextInput::make('email')
                                        ->label('Email')
                                        ->email(),
                                    TextInput::make('role_title')
                                        ->label('Title'),
                                ]),
                            TextInput::make('job_title')
                                ->label('Job Title / Designation')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('e.g. Senior Laravel Engineer'),
                            TextInput::make('job_url')
                                ->label('Job Posting URL')
                                ->url()
                                ->placeholder('https://boards.greenhouse.io/...'),
                            Select::make('employment_type')
                                ->label('Employment Type')
                                ->options(EmploymentType::class)
                                ->default(EmploymentType::FullTime)
                                ->required(),
                            Select::make('location_type')
                                ->label('Workplace Type')
                                ->options(LocationType::class)
                                ->default(LocationType::Remote)
                                ->required(),
                            TextInput::make('location')
                                ->label('Location / City')
                                ->placeholder('e.g. Manila, Philippines or Remote US')
                                ->columnSpanFull(),
                            Textarea::make('description')
                                ->label('Job Description / Key Requirements')
                                ->rows(4)
                                ->columnSpanFull(),
                        ]),
                    ]),

                Section::make('Compensation')
                    ->description('Salary ranges, currency, and formal offer details.')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('currency')
                                ->label('Currency')
                                ->default('USD')
                                ->maxLength(10)
                                ->required(),
                            Select::make('salary_period')
                                ->label('Pay Frequency')
                                ->options(SalaryPeriod::class)
                                ->default(SalaryPeriod::Yearly)
                                ->required(),
                            TextInput::make('priority_rating')
                                ->label('Interest / Priority (1 - 5)')
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(5)
                                ->default(3)
                                ->required(),
                            TextInput::make('salary_min')
                                ->label('Minimum Salary')
                                ->numeric()
                                ->prefix('$'),
                            TextInput::make('salary_max')
                                ->label('Maximum Salary')
                                ->numeric()
                                ->prefix('$'),
                            TextInput::make('salary_offered')
                                ->label('Offered Salary')
                                ->numeric()
                                ->prefix('$'),
                        ]),
                    ]),

                Section::make('Pipeline Lifecycle & Timeline')
                    ->description('Current stage progression and key recruitment milestones.')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('status')
                                ->label('Pipeline Stage')
                                ->options(ApplicationStatus::class)
                                ->default(ApplicationStatus::Applied)
                                ->required()
                                ->columnSpanFull(),
                            DatePicker::make('applied_date')
                                ->label('Date Applied')
                                ->default(now()),
                            DatePicker::make('deadline_date')
                                ->label('Application / Response Deadline'),
                            DatePicker::make('decision_date')
                                ->label('Decision / Offer Date')
                                ->columnSpanFull(),
                        ]),
                    ]),

                Section::make('Personal Notes & Follow-ups')
                    ->description('Application thoughts, referral details, or talking points.')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notes & Reflections')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
