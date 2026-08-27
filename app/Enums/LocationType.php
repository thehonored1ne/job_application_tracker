<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum LocationType: string implements HasColor, HasIcon, HasLabel
{
    case Remote = 'remote';
    case Hybrid = 'hybrid';
    case Onsite = 'onsite';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Remote => 'Remote',
            self::Hybrid => 'Hybrid',
            self::Onsite => 'On-site',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Remote => 'success',
            self::Hybrid => 'warning',
            self::Onsite => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Remote => 'heroicon-o-home',
            self::Hybrid => 'heroicon-o-arrows-right-left',
            self::Onsite => 'heroicon-o-building-office',
        };
    }
}
