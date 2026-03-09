<?php

namespace App\Filament\Pages\KepalaSekolah;

use Filament\Pages\Page;

class MonitoringAll extends Page
{
    protected string $view = 'filament.pages.kepala-sekolah.monitoring-all';
    protected static ?string $navigationLabel = 'Monitoring All';
    protected static ?string $title = 'Monitoring All';
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-chart-bar';
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && $user->level === 'kepalasekolah';
    }
}