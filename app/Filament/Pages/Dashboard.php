<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int | array
    {
        return 2;
    }

    public static function canAccess(): bool
    {
        return auth()->check();
    }

    public function getWidgets(): array
    {
        $user = auth()->user();
        
        if (!$user) {
            return [];
        }

        $widgets = [];

        // Admin melihat semua widget
        if ($user->level === 'admin') {
            $widgets = [
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\PelanggaranChart::class,
                \App\Filament\Widgets\PrestasiChart::class,
            ];
        }
        // Kesiswaan melihat widget pelanggaran dan prestasi
        elseif ($user->level === 'kesiswaan') {
            $widgets = [
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\PelanggaranChart::class,
                \App\Filament\Widgets\PrestasiChart::class,
            ];
        }
        // Kepala Sekolah melihat monitoring
        elseif ($user->level === 'kepalasekolah') {
            $widgets = [
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\PelanggaranChart::class,
            ];
        }
        // BK melihat bimbingan konseling
        elseif ($user->level === 'bk') {
            $widgets = [
                \App\Filament\Widgets\StatsOverview::class,
            ];
        }
        // Guru dan Wali Kelas melihat data sendiri
        elseif (in_array($user->level, ['guru', 'walikelas'])) {
            $widgets = [
                \App\Filament\Widgets\StatsOverview::class,
            ];
        }

        return $widgets;
    }
}
