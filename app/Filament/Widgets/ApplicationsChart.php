<?php

namespace App\Filament\Widgets;

use App\Models\JobApplication;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ApplicationsChart extends ChartWidget
{
    protected ?string $heading = 'Application Velocity (Past 6 Months)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => Carbon::now()->subMonths($i));

        $labels = [];
        $data = [];

        foreach ($months as $month) {
            $monthLabel = $month->format('M Y');
            $labels[] = $monthLabel;

            $count = JobApplication::query()
                ->nonWishlist()
                ->whereYear('applied_date', $month->year)
                ->whereMonth('applied_date', $month->month)
                ->count();

            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Applications Submitted',
                    'data' => $data,
                    'fill' => 'start',
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
