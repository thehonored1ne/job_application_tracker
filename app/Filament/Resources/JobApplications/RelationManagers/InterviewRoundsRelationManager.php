<?php

namespace App\Filament\Resources\JobApplications\RelationManagers;

use App\Enums\RoundStatus;
use App\Enums\RoundType;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InterviewRoundsRelationManager extends RelationManager
{
    protected static string $relationship = 'interviewRounds';

    protected static ?string $title = 'Interview Rounds & Logs';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Round Details')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('round_type')
                                ->label('Round Type')
                                ->options(RoundType::class)
                                ->default(RoundType::Screening)
                                ->required(),
                            Select::make('status')
                                ->label('Round Status')
                                ->options(RoundStatus::class)
                                ->default(RoundStatus::Scheduled)
                                ->required(),
                            DateTimePicker::make('scheduled_at')
                                ->label('Date & Time')
                                ->seconds(false),
                            TextInput::make('duration_minutes')
                                ->label('Duration')
                                ->numeric()
                                ->default(45)
                                ->suffix('minutes'),
                            TextInput::make('meeting_url')
                                ->label('Meeting Link (Zoom / Meet / Teams)')
                                ->url()
                                ->columnSpanFull(),
                            TextInput::make('location')
                                ->label('Physical Location / Room')
                                ->placeholder('e.g. Office Boardroom 4B or Remote')
                                ->columnSpanFull(),
                        ]),
                    ]),

                Section::make('Interviewer Information')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('interviewer_name')
                                ->label('Interviewer Name')
                                ->maxLength(255),
                            TextInput::make('interviewer_title')
                                ->label('Interviewer Title')
                                ->placeholder('e.g. Director of Engineering')
                                ->maxLength(255),
                            TextInput::make('interviewer_email')
                                ->label('Email Address')
                                ->email()
                                ->maxLength(255),
                            TextInput::make('interviewer_linkedin')
                                ->label('LinkedIn URL')
                                ->url()
                                ->maxLength(255),
                        ]),
                    ])
                    ->collapsible(),

                Section::make('Preparation, Questions & Takeaways')
                    ->schema([
                        Select::make('rating')
                            ->label('Self-Assessment Performance (1 to 5 Stars)')
                            ->options([
                                1 => '1 - Needs Improvement',
                                2 => '2 - Fair',
                                3 => '3 - Good / Average',
                                4 => '4 - Very Strong',
                                5 => '5 - Exceptional',
                            ]),
                        Textarea::make('prep_notes')
                            ->label('Preparation Notes & Talking Points')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('questions_asked')
                            ->label('Questions Asked by Interviewer')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('takeaways')
                            ->label('Post-Interview Reflection & Next Steps')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('round_type')
            ->defaultSort('scheduled_at', 'desc')
            ->columns([
                TextColumn::make('round_type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('scheduled_at')
                    ->label('Scheduled Time')
                    ->dateTime('M j, Y - g:i A')
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label('Duration')
                    ->formatStateUsing(fn ($state) => $state ? "{$state}m" : '-'),
                TextColumn::make('interviewer_name')
                    ->label('Interviewer')
                    ->description(fn ($record) => $record->interviewer_title)
                    ->searchable(),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->badge()
                    ->color(fn ($state) => $state >= 4 ? 'success' : ($state >= 3 ? 'warning' : 'gray'))
                    ->formatStateUsing(fn ($state) => $state ? str_repeat('★', (int) $state) : '-')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(RoundStatus::class),
                SelectFilter::make('round_type')
                    ->options(RoundType::class),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                Action::make('join_meeting')
                    ->label('Join')
                    ->icon('heroicon-m-video-camera')
                    ->color('success')
                    ->url(fn ($record) => $record->meeting_url, true)
                    ->visible(fn ($record) => ! empty($record->meeting_url)),
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
