<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\ADS;
use App\Models\City;
use App\Models\Category;
use App\Models\Shop;

class StatsOverview extends BaseWidget
{
    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = '3s';

    protected function getStats(): array
    {
        return [
            Stat::make('Shop', Shop::where("is_active",1)->count())
            ->description('Shop List On Our Platform')
            ->color('success'),
            Stat::make('ADS', ADS::where("is_active",1)->count())
                ->description('ADS List On Our Platform')
                ->color('success'),
            Stat::make('City', City::where("is_active",1)->count())
                ->description('City List On Our Platform')
                ->color('success'),
            Stat::make('Today Traffic', '30K')
                ->description('7% increase'),
            Stat::make('Average time on page', '3:12')
                ->description('3% increase'),
                
        ];
    }
}
