<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class HeaderWidget extends Widget
{
    protected string $view = 'filament.widgets.header-widget';

    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->check();
    }
}
