<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum RoundStatus: string implements HasColor, HasIcon, HasLabel
{
    case Scheduled = 'scheduled';
    case Completed = 'completed';
    case Passed = 'passed';
    case Failed = 'failed';
    case Cancelled = 'cancelled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Scheduled => 'Scheduled',
            self::Completed => 'Completed',
            self::Passed => 'Passed',
            self::Failed => 'Failed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Scheduled => 'warning',
            self::Completed => 'info',
            self::Passed => 'success',
            self::Failed => 'danger',
            self::Cancelled => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Scheduled => 'heroicon-o-calendar',
            self::Completed => 'heroicon-o-check',
            self::Passed => 'heroicon-o-check-circle',
            self::Failed => 'heroicon-o-x-circle',
            self::Cancelled => 'heroicon-o-no-symbol',
        };
    }
}
