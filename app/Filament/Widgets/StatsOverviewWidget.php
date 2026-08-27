<?php

namespace App\Filament\Widgets;

use App\Models\JobApplication;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalApplied = JobApplication::nonWishlist()->count();
        $activeInterviews = JobApplication::activeInterviews()->count();
        $offers = JobApplication::offers()->count();

        $interviewRate = $totalApplied > 0
            ? round(($activeInterviews / $totalApplied) * 100, 1)
            : 0;

        $offerRate = $totalApplied > 0
            ? round(($offers / $totalApplied) * 100, 1)
            : 0;

        return [
            Stat::make('Total Applications', $totalApplied)
                ->description('Active pipeline (excluding wishlist)')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary')
                ->chart([3, 5, 8, 12, 15, max($totalApplied, 1)]),

            Stat::make('Active Interviews', $activeInterviews)
                ->description('Screening, technical & final stages')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning')
                ->chart([1, 2, 3, 2, 4, max($activeInterviews, 1)]),

            Stat::make('Offers Received', $offers)
                ->description('Formal offers & accepted roles')
                ->descriptionIcon('heroicon-m-gift')
                ->color('success')
                ->chart([0, 0, 1, 1, max($offers, 1)]),

            Stat::make('Interview Rate', "{$interviewRate}%")
                ->description('Application-to-interview velocity')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($interviewRate >= 20 ? 'success' : 'info'),

            Stat::make('Offer Conversion', "{$offerRate}%")
                ->description('Total offer conversion rate')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color($offerRate >= 10 ? 'success' : 'primary'),
        ];
    }
}
