<?php

namespace App\Filament\Resources\Companies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=C&background=0D8ABC&color=fff'),
                TextColumn::make('name')
                    ->label('Company')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('industry')
                    ->label('Industry')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->icon('heroicon-m-map-pin'),
                TextColumn::make('website')
                    ->label('Website')
                    ->url(fn ($record) => $record->website, true)
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->iconPosition('after')
                    ->toggleable(),
                TextColumn::make('job_applications_count')
                    ->label('Applications')
                    ->counts('jobApplications')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('contacts_count')
                    ->label('Contacts')
                    ->counts('contacts')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
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
