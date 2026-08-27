<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Professional Information')
                    ->description('Contact identity, employer, and role designation.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('full_name')
                                ->label('Full Name')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('e.g. Jane Doe'),
                            Select::make('company_id')
                                ->label('Associated Company')
                                ->relationship('company', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->label('Company Name')
                                        ->required(),
                                    TextInput::make('website')
                                        ->label('Website')
                                        ->url(),
                                ]),
                            TextInput::make('role_title')
                                ->label('Role / Title')
                                ->placeholder('e.g. Senior Tech Recruiter / Hiring Manager')
                                ->maxLength(255),
                            TextInput::make('linkedin_url')
                                ->label('LinkedIn Profile URL')
                                ->url()
                                ->prefix('https://')
                                ->placeholder('linkedin.com/in/username')
                                ->maxLength(255),
                        ]),
                    ]),

                Section::make('Communication & Notes')
                    ->description('Direct outreach channels and interaction history.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('email')
                                ->label('Email Address')
                                ->email()
                                ->placeholder('jane@example.com')
                                ->maxLength(255),
                            TextInput::make('phone')
                                ->label('Phone / Mobile')
                                ->tel()
                                ->placeholder('+1 (555) 000-0000')
                                ->maxLength(255),
                        ]),
                        Textarea::make('notes')
                            ->label('Interaction Notes & Context')
                            ->rows(4)
                            ->placeholder('Referral source, connection background, recent conversations...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
