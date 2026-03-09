<?php

namespace App\Filament\Pages\OrangTua;

use Filament\Pages\Page;

class ViewDataAnak extends Page
{
    protected string $view = 'filament.pages.orang-tua.view-data-anak';
    protected static ?string $navigationLabel = 'Data Anak';
    protected static ?string $title = 'Data Anak';
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-user-group';
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && $user->level === 'ortu';
    }
}