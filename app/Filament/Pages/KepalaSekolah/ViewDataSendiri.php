<?php

namespace App\Filament\Pages\KepalaSekolah;

use Illuminate\Support\Facades\Auth;

use Filament\Pages\Page;

class ViewDataSendiri extends Page
{
    protected string $view = 'filament.pages.kepala-sekolah.view-data-sendiri';
    protected static ?string $navigationLabel = 'View Data Sendiri';
    protected static ?string $title = 'View Data Sendiri';
    protected static ?int $navigationSort = 2;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-eye';
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'kepalasekolah';
    }
}