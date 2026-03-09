<?php

namespace App\Filament\Pages\WaliKelas;

use Filament\Pages\Page;

class ExportLaporan extends Page
{
    protected string $view = 'filament.pages.wali-kelas.export-laporan';
    protected static ?string $navigationLabel = 'Export Laporan';
    protected static ?string $title = 'Export Laporan';
    protected static ?int $navigationSort = 3;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-arrow-down-tray';
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && $user->level === 'walikelas';
    }
}