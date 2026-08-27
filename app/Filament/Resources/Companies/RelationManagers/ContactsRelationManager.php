<?php

namespace App\Filament\Resources\Companies\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('full_name')
                        ->label('Full Name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('role_title')
                        ->label('Role / Title')
                        ->placeholder('e.g. Technical Recruiter')
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('Email Address')
                        ->email()
                        ->maxLength(255),
                    TextInput::make('phone')
                        ->label('Phone Number')
                        ->tel()
                        ->maxLength(255),
                    TextInput::make('linkedin_url')
                        ->label('LinkedIn Profile URL')
                        ->url()
                        ->columnSpanFull(),
                    Textarea::make('notes')
                        ->label('Notes')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('role_title')
                    ->label('Role / Title')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-m-envelope')
                    ->url(fn ($record) => $record->email ? "mailto:{$record->email}" : null),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->icon('heroicon-m-phone')
                    ->url(fn ($record) => $record->phone ? "tel:{$record->phone}" : null)
                    ->toggleable(),
                TextColumn::make('linkedin_url')
                    ->label('LinkedIn')
                    ->icon('heroicon-m-link')
                    ->url(fn ($record) => $record->linkedin_url, true)
                    ->toggleable(),
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
