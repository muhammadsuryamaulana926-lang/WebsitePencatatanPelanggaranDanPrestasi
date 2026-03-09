<?php

namespace App\Filament\Pages\Kesiswaan;

use Filament\Pages\Page;

class InputPelanggaran extends Page
{
    protected string $view = 'filament.pages.kesiswaan.input-pelanggaran';
    protected static ?string $navigationLabel = 'Input Pelanggaran';
    protected static ?string $title = 'Input Pelanggaran';
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-exclamation-triangle';
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && $user->level === 'kesiswaan';
    }
}