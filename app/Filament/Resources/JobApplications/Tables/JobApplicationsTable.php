<?php

namespace App\Filament\Resources\JobApplications\Tables;

use App\Enums\ApplicationStatus;
use App\Enums\EmploymentType;
use App\Enums\LocationType;
use App\Models\JobApplication;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['company', 'contact']))
            ->defaultSort('applied_date', 'desc')
            ->columns([
                ImageColumn::make('company.logo_path')
                    ->label('Logo')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=J&background=6366F1&color=fff'),
                TextColumn::make('company.name')
                    ->label('Company')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->url(fn ($record) => $record->company_id ? route('filament.admin.resources.companies.edit', ['record' => $record->company_id]) : null),
                TextColumn::make('job_title')
                    ->label('Job Title')
                    ->searchable()
                    ->sortable()
                    ->description(fn (JobApplication $record) => $record->contact?->full_name ? "Recruiter: {$record->contact->full_name}" : null),
                TextColumn::make('status')
                    ->label('Pipeline Stage')
                    ->badge()
                    ->sortable(),
                TextColumn::make('employment_type')
                    ->label('Type')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('location_type')
                    ->label('Workplace')
                    ->badge()
                    ->description(fn (JobApplication $record) => $record->location)
                    ->toggleable(),
                TextColumn::make('salary_range')
                    ->label('Compensation')
                    ->state(function (JobApplication $record) {
                        if ($record->salary_offered) {
                            return '$'.number_format((float) $record->salary_offered).' (Offered)';
                        }
                        if ($record->salary_min && $record->salary_max) {
                            return '$'.number_format((float) $record->salary_min).' - $'.number_format((float) $record->salary_max);
                        }
                        if ($record->salary_min) {
                            return 'From $'.number_format((float) $record->salary_min);
                        }

                        return '-';
                    })
                    ->description(fn (JobApplication $record) => $record->salary_period?->getLabel())
                    ->toggleable(),
                TextColumn::make('priority_rating')
                    ->label('Priority')
                    ->badge()
                    ->color(fn ($state) => $state >= 4 ? 'success' : ($state >= 3 ? 'warning' : 'gray'))
                    ->formatStateUsing(fn ($state) => str_repeat('★', (int) $state))
                    ->sortable(),
                TextColumn::make('applied_date')
                    ->label('Applied')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Stage')
                    ->options(ApplicationStatus::class),
                SelectFilter::make('company_id')
                    ->label('Company')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('location_type')
                    ->label('Location Type')
                    ->options(LocationType::class),
                SelectFilter::make('employment_type')
                    ->label('Employment Type')
                    ->options(EmploymentType::class),
                Filter::make('active_interviews')
                    ->label('In Interview Stage')
                    ->query(fn (Builder $query): Builder => $query->activeInterviews()),
                Filter::make('high_priority')
                    ->label('High Priority (4+ Stars)')
                    ->query(fn (Builder $query): Builder => $query->highPriority(4)),
            ])
            ->recordActions([
                Action::make('update_status')
                    ->label('Move Stage')
                    ->icon('heroicon-m-arrow-path')
                    ->color('warning')
                    ->form([
                        Select::make('status')
                            ->label('New Pipeline Stage')
                            ->options(ApplicationStatus::class)
                            ->default(fn (JobApplication $record) => $record->status)
                            ->required(),
                    ])
                    ->action(function (JobApplication $record, array $data): void {
                        $record->update(['status' => $data['status']]);
                        Notification::make()
                            ->title('Application Stage Updated')
                            ->success()
                            ->send();
                    }),
                Action::make('view_listing')
                    ->label('Job Post')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn ($record) => $record->job_url, true)
                    ->visible(fn ($record) => ! empty($record->job_url)),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
