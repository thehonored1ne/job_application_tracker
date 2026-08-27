<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Company Details')
                    ->description('General information and branding for the organization.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Company Name')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('e.g. Stripe, Google, Acme Corp'),
                            TextInput::make('website')
                                ->label('Website URL')
                                ->url()
                                ->prefix('https://')
                                ->placeholder('stripe.com')
                                ->maxLength(255),
                            TextInput::make('industry')
                                ->label('Industry / Sector')
                                ->placeholder('e.g. Fintech, SaaS, Developer Tools')
                                ->maxLength(255),
                            TextInput::make('location')
                                ->label('Headquarters / Office Location')
                                ->placeholder('e.g. San Francisco, CA or Remote')
                                ->maxLength(255),
                        ]),
                        FileUpload::make('logo_path')
                            ->label('Company Logo')
                            ->image()
                            ->directory('company-logos')
                            ->imageResizeMode('cover')
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ]),

                Section::make('Research & Company Notes')
                    ->description('Culture, engineering values, interview insights, and Glassdoor notes.')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Internal Notes')
                            ->rows(4)
                            ->placeholder('Add research about company tech stack, recent funding, interview expectations...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
