<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStatus;
use App\Models\JobApplication;
use Filament\Widgets\ChartWidget;

class StageDistributionChart extends ChartWidget
{
    protected ?string $heading = 'Pipeline Stage Breakdown';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $wishlist = JobApplication::where('status', ApplicationStatus::Wishlist)->count();
        $applied = JobApplication::where('status', ApplicationStatus::Applied)->count();
        $interviews = JobApplication::activeInterviews()->count();
        $offers = JobApplication::offers()->count();
        $closed = JobApplication::whereIn('status', [
            ApplicationStatus::Rejected,
            ApplicationStatus::Withdrawn,
        ])->count();

        return [
            'datasets' => [
                [
                    'label' => 'Applications',
                    'data' => [$wishlist, $applied, $interviews, $offers, $closed],
                    'backgroundColor' => [
                        '#94a3b8', // Wishlist (Slate)
                        '#38bdf8', // Applied (Sky)
                        '#f59e0b', // In Interview (Amber)
                        '#10b981', // Offers (Emerald)
                        '#ef4444', // Closed (Rose)
                    ],
                ],
            ],
            'labels' => ['Wishlist', 'Applied', 'In Interview', 'Offers', 'Rejected / Withdrawn'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
