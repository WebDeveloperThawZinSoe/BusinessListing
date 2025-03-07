<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Traffic;
use Carbon\Carbon;

class MobileTrafficChart extends ChartWidget
{
    protected static ?string $heading = 'Mobile Traffic (Mobile)';
    protected static string $type = 'line';

    protected static ?int $sort = 20;

    protected function getData(): array
    {
        $trafficData = Traffic::where('date', '>=', Carbon::now()->subDays(7))->where("type","mobile")
        ->orderBy('date')
        ->pluck('count', 'date')
        ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Daily Visitors',
                    'data' => array_values($trafficData),
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'fill' => true,
                    'tension' =>1, // Smooth curve
                ],
            ],
            'labels' => array_keys($trafficData),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
