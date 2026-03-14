<?php

namespace App\Filament\Pages\Kesiswaan;

use Illuminate\Support\Facades\Auth;

use Filament\Pages\Page;

class ViewDataSendiri extends Page
{
    protected string $view = 'filament.pages.kesiswaan.view-data-sendiri';
    protected static ?string $navigationLabel = 'View Data Sendiri';
    protected static ?string $title = 'View Data Sendiri';
    protected static ?int $navigationSort = 3;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-eye';
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'kesiswaan';
    }
}