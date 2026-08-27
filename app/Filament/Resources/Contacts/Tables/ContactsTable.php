<?php

namespace App\Filament\Resources\Contacts\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('company'))
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('company.name')
                    ->label('Company')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->url(fn ($record) => $record->company_id ? route('filament.admin.resources.companies.edit', ['record' => $record->company_id]) : null),
                TextColumn::make('role_title')
                    ->label('Role / Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->copyable()
                    ->url(fn ($record) => $record->email ? "mailto:{$record->email}" : null),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->icon('heroicon-m-phone')
                    ->url(fn ($record) => $record->phone ? "tel:{$record->phone}" : null)
                    ->toggleable(),
                TextColumn::make('linkedin_url')
                    ->label('LinkedIn')
                    ->icon('heroicon-m-link')
                    ->url(fn ($record) => $record->linkedin_url, true)
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('company_id')
                    ->label('Filter by Company')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                Action::make('email_contact')
                    ->label('Email')
                    ->icon('heroicon-m-envelope')
                    ->color('info')
                    ->url(fn ($record) => "mailto:{$record->email}")
                    ->visible(fn ($record) => ! empty($record->email)),
                Action::make('linkedin')
                    ->label('LinkedIn')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn ($record) => $record->linkedin_url, true)
                    ->visible(fn ($record) => ! empty($record->linkedin_url)),
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
