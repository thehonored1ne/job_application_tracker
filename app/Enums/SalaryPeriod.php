<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SalaryPeriod: string implements HasLabel
{
    case Yearly = 'yearly';
    case Monthly = 'monthly';
    case Hourly = 'hourly';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Yearly => 'Yearly',
            self::Monthly => 'Monthly',
            self::Hourly => 'Hourly',
        };
    }
}
