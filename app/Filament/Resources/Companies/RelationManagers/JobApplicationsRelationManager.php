<?php

namespace App\Filament\Resources\Companies\RelationManagers;

use App\Enums\ApplicationStatus;
use App\Enums\EmploymentType;
use App\Enums\LocationType;
use App\Enums\SalaryPeriod;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobApplicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'jobApplications';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('job_title')
                        ->label('Job Title')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('job_url')
                        ->label('Job Posting URL')
                        ->url(),
                    Select::make('employment_type')
                        ->label('Employment Type')
                        ->options(EmploymentType::class)
                        ->default(EmploymentType::FullTime)
                        ->required(),
                    Select::make('location_type')
                        ->label('Location Type')
                        ->options(LocationType::class)
                        ->default(LocationType::Remote)
                        ->required(),
                    Select::make('status')
                        ->label('Pipeline Status')
                        ->options(ApplicationStatus::class)
                        ->default(ApplicationStatus::Applied)
                        ->required(),
                    TextInput::make('priority_rating')
                        ->label('Priority (1-5)')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(5)
                        ->default(3)
                        ->required(),
                    TextInput::make('salary_min')
                        ->label('Salary Min')
                        ->numeric()
                        ->prefix('$'),
                    TextInput::make('salary_max')
                        ->label('Salary Max')
                        ->numeric()
                        ->prefix('$'),
                    Select::make('salary_period')
                        ->label('Period')
                        ->options(SalaryPeriod::class)
                        ->default(SalaryPeriod::Yearly),
                    DatePicker::make('applied_date')
                        ->label('Date Applied')
                        ->default(now()),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('job_title')
            ->columns([
                TextColumn::make('job_title')
                    ->label('Role')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('employment_type')
                    ->label('Type')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('location_type')
                    ->label('Location')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('applied_date')
                    ->label('Applied')
                    ->date()
                    ->sortable(),
                TextColumn::make('priority_rating')
                    ->label('Priority')
                    ->badge()
                    ->color(fn ($state) => $state >= 4 ? 'success' : ($state >= 3 ? 'warning' : 'gray'))
                    ->formatStateUsing(fn ($state) => str_repeat('★', (int) $state)),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
