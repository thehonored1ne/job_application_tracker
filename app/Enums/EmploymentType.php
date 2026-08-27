<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum EmploymentType: string implements HasColor, HasIcon, HasLabel
{
    case FullTime = 'full_time';
    case PartTime = 'part_time';
    case Contract = 'contract';
    case Internship = 'internship';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FullTime => 'Full-time',
            self::PartTime => 'Part-time',
            self::Contract => 'Contract',
            self::Internship => 'Internship',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::FullTime => 'primary',
            self::PartTime => 'info',
            self::Contract => 'warning',
            self::Internship => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::FullTime => 'heroicon-o-briefcase',
            self::PartTime => 'heroicon-o-clock',
            self::Contract => 'heroicon-o-document-text',
            self::Internship => 'heroicon-o-academic-cap',
        };
    }
}
