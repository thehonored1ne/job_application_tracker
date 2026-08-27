<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum RoundType: string implements HasColor, HasIcon, HasLabel
{
    case Screening = 'screening';
    case Technical = 'technical';
    case SystemDesign = 'system_design';
    case Behavioral = 'behavioral';
    case TakeHome = 'take_home';
    case Final = 'final';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Screening => 'Screening',
            self::Technical => 'Technical Interview',
            self::SystemDesign => 'System Design',
            self::Behavioral => 'Behavioral / Manager',
            self::TakeHome => 'Take Home Assignment',
            self::Final => 'Final Round',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Screening => 'warning',
            self::Technical => 'purple',
            self::SystemDesign => 'info',
            self::Behavioral => 'cyan',
            self::TakeHome => 'primary',
            self::Final => 'orange',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Screening => 'heroicon-o-phone',
            self::Technical => 'heroicon-o-code-bracket',
            self::SystemDesign => 'heroicon-o-server-stack',
            self::Behavioral => 'heroicon-o-user-group',
            self::TakeHome => 'heroicon-o-document-check',
            self::Final => 'heroicon-o-presentation-chart-bar',
        };
    }
}
