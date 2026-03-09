<?php

namespace App\Filament\Pages\KepalaSekolah;

use Filament\Pages\Page;

class RiwayatPelanggaran extends Page
{
    protected string $view = 'filament.pages.kepala-sekolah.riwayat-pelanggaran';
    protected static ?string $navigationLabel = 'Riwayat Pelanggaran';
    protected static ?string $title = 'Riwayat Pelanggaran';
    protected static ?int $navigationSort = 3;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-clock';
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && $user->level === 'kepalasekolah';
    }
}