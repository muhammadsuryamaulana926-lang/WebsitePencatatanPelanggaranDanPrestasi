<?php

namespace App\Filament\Pages\Kesiswaan;

use Filament\Pages\Page;

class ViewDataAnak extends Page
{
    protected string $view = 'filament.pages.kesiswaan.view-data-anak';
    protected static ?string $navigationLabel = 'View Data Anak';
    protected static ?string $title = 'View Data Anak';
    protected static ?int $navigationSort = 4;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-users';
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && $user->level === 'kesiswaan';
    }
}