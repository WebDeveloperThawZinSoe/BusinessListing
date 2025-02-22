<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\ADS;
use App\Models\City;
use App\Models\Category;
use App\Models\Shop;
use App\Models\Product;

class StatsOverview extends BaseWidget
{
    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = '3s';

    protected function getStats(): array
    {
        return [
            Stat::make('Shop', Shop::count())
            ->description('Shop Count On Our Platform')
            ->color('success'),
            Stat::make('Product', Product::count())
            ->description('Product Count On Our Platform')
            ->color('success'),
            Stat::make('ADS', ADS::where("is_active",1)->count())
                ->description('Active ADS Count On Our Platform')
                ->color('success'),
            Stat::make('City', City::where("is_active",1)->count())
                ->description('Active City Count On Our Platform')
                ->color('success'),
            Stat::make('Category', Category::where("is_active",1)->count())
                ->description('Active Category Count On Our Platform')
                ->color('success'),
            Stat::make('Average time on page', '3:12')
                ->description('3% increase'),
                
        ];
    }
}
