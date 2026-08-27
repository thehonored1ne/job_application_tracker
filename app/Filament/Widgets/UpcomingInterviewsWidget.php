<?php

namespace App\Filament\Widgets;

use App\Models\InterviewRound;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingInterviewsWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Upcoming Scheduled Interviews';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => InterviewRound::query()
                    ->upcoming()
                    ->with(['jobApplication.company'])
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('scheduled_at')
                    ->label('Date & Time')
                    ->dateTime('l, M j, Y - g:i A')
                    ->description(fn (InterviewRound $record) => $record->scheduled_at?->diffForHumans())
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('jobApplication.company.name')
                    ->label('Company')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('jobApplication.job_title')
                    ->label('Role')
                    ->searchable(),
                TextColumn::make('round_type')
                    ->label('Round Type')
                    ->badge(),
                TextColumn::make('duration_minutes')
                    ->label('Duration')
                    ->formatStateUsing(fn ($state) => $state ? "{$state} mins" : '-'),
                TextColumn::make('interviewer_name')
                    ->label('Interviewer')
                    ->description(fn (InterviewRound $record) => $record->interviewer_title)
                    ->placeholder('-'),
            ])
            ->recordActions([
                Action::make('join_meeting')
                    ->label('Join Meeting')
                    ->icon('heroicon-m-video-camera')
                    ->button()
                    ->color('success')
                    ->url(fn (InterviewRound $record) => $record->meeting_url, true)
                    ->visible(fn (InterviewRound $record) => ! empty($record->meeting_url)),
                Action::make('view_application')
                    ->label('View Role')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn (InterviewRound $record) => route('filament.admin.resources.job-applications.edit', ['record' => $record->job_application_id])),
            ])
            ->emptyStateHeading('No Upcoming Interviews')
            ->emptyStateDescription('When you schedule new interview rounds, they will appear here with 1-click meeting links.')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }
}
