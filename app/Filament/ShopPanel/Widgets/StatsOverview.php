<?php

namespace App\Filament\ShopPanel\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Traffic;
use App\Models\ShopGallery;
use App\Models\SocialAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $todayTraffic = Traffic::where("date", Carbon::today())->value("count") ?? 0;

        // Fetch the shop IDs for the authenticated user
        $shopIds = Auth::user()->shops->pluck('id')->toArray();  

        $productCount = Product::whereIn('shop_id', $shopIds)->count(); 
        $galleryCount = ShopGallery::whereIn('shop_id', $shopIds)->count(); 
        $socialCount = SocialAccount::whereIn('shop_id', $shopIds)->count(); 
        $shopCount = Shop::where("user_id", Auth::id())->count();

        return [
            Stat::make('Total Shops', $shopCount)
                ->description('Shops owned by you')
                ->color('success'),

            Stat::make('Total Products', $productCount)
                ->description('Products listed across your shops')
                ->color('info'),

            Stat::make('Gallery Images', $galleryCount)
                ->description('Images uploaded for shop listings')
                ->color('warning'),

            Stat::make('Connected Accounts', $socialCount)
                ->description('Social media accounts linked to your shops')
                ->color('purple'),

            // Stat::make('Today’s Visitors', $todayTraffic)
            //     ->description('Number of visitors to your shop today')
            //     ->color('primary'),
        ];
    }

    protected function getColumns(): int
    {
        return 2; // Display 3 stats per row for a balanced layout
    }
}
