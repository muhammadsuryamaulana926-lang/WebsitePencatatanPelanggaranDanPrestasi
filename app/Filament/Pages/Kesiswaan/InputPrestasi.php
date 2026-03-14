<?php

namespace App\Filament\Pages\Kesiswaan;

use Illuminate\Support\Facades\Auth;

use Filament\Pages\Page;

class InputPrestasi extends Page
{
    protected string $view = 'filament.pages.kesiswaan.input-prestasi';
    protected static ?string $navigationLabel = 'Input Prestasi';
    protected static ?string $title = 'Input Prestasi';
    protected static ?int $navigationSort = 2;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-trophy';
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'kesiswaan';
    }
}