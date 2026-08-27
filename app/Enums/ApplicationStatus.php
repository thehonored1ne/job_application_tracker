<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ApplicationStatus: string implements HasColor, HasIcon, HasLabel
{
    case Wishlist = 'wishlist';
    case Applied = 'applied';
    case Screening = 'screening';
    case TechnicalInterview = 'technical_interview';
    case BehavioralInterview = 'behavioral_interview';
    case FinalRound = 'final_round';
    case OfferReceived = 'offer_received';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Withdrawn = 'withdrawn';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Wishlist => 'Wishlist / Saved',
            self::Applied => 'Applied',
            self::Screening => 'Screening',
            self::TechnicalInterview => 'Technical Interview',
            self::BehavioralInterview => 'Behavioral / Manager',
            self::FinalRound => 'Final Round',
            self::OfferReceived => 'Offer Received',
            self::Accepted => 'Accepted',
            self::Rejected => 'Rejected',
            self::Withdrawn => 'Withdrawn',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Wishlist => 'gray',
            self::Applied => 'info',
            self::Screening => 'warning',
            self::TechnicalInterview => 'purple',
            self::BehavioralInterview => 'cyan',
            self::FinalRound => 'orange',
            self::OfferReceived, self::Accepted => 'success',
            self::Rejected => 'danger',
            self::Withdrawn => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Wishlist => 'heroicon-o-bookmark',
            self::Applied => 'heroicon-o-paper-airplane',
            self::Screening => 'heroicon-o-phone',
            self::TechnicalInterview => 'heroicon-o-code-bracket',
            self::BehavioralInterview => 'heroicon-o-user-group',
            self::FinalRound => 'heroicon-o-presentation-chart-bar',
            self::OfferReceived => 'heroicon-o-gift',
            self::Accepted => 'heroicon-o-check-badge',
            self::Rejected => 'heroicon-o-x-circle',
            self::Withdrawn => 'heroicon-o-arrow-uturn-left',
        };
    }

    public function isInterviewStage(): bool
    {
        return in_array($this, [
            self::Screening,
            self::TechnicalInterview,
            self::BehavioralInterview,
            self::FinalRound,
        ]);
    }

    public function isActive(): bool
    {
        return in_array($this, [
            self::Applied,
            self::Screening,
            self::TechnicalInterview,
            self::BehavioralInterview,
            self::FinalRound,
            self::OfferReceived,
        ]);
    }

    public function isClosed(): bool
    {
        return in_array($this, [
            self::Accepted,
            self::Rejected,
            self::Withdrawn,
        ]);
    }
}
