<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Facades\Auth;

class SidebarLogoutWidget extends Widget
{
    protected static string $view = 'filament.widgets.sidebar-logout-widget';

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Filament::auth()->check(); // Only show if authenticated
    }
}
