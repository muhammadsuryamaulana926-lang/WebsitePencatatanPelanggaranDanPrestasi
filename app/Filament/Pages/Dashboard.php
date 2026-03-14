<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int | array
    {
        return 2;
    }

    public static function canAccess(): bool
    {
        return Auth::check();
    }

    public function getWidgets(): array
    {
        $user = Auth::user();
        
        if (!$user) {
            return [];
        }

        $widgets = [];

        // Admin melihat semua widget
        if ($user->level === 'admin') {
            $widgets = [
                \App\Filament\Widgets\QuickActions::class,
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\LatestPelanggaran::class,
                \App\Filament\Widgets\PelanggaranChart::class,
                \App\Filament\Widgets\PrestasiChart::class,
            ];
        }
        // Kesiswaan melihat widget pelanggaran dan prestasi
        elseif ($user->level === 'kesiswaan') {
            $widgets = [
                \App\Filament\Widgets\QuickActions::class,
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\LatestPelanggaran::class,
                \App\Filament\Widgets\PelanggaranChart::class,
                \App\Filament\Widgets\PrestasiChart::class,
            ];
        }
        // Kepala Sekolah melihat monitoring
        elseif ($user->level === 'kepalasekolah') {
            $widgets = [
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\LatestPelanggaran::class,
                \App\Filament\Widgets\PelanggaranChart::class,
            ];
        }
        // BK melihat bimbingan konseling
        elseif ($user->level === 'bk') {
            $widgets = [
                \App\Filament\Widgets\QuickActions::class,
                \App\Filament\Widgets\StatsOverview::class,
            ];
        }
        // Guru dan Wali Kelas melihat data sendiri
        elseif (in_array($user->level, ['guru', 'walikelas'])) {
            $widgets = [
                \App\Filament\Widgets\QuickActions::class,
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\LatestPelanggaran::class,
            ];
        }
        // Siswa dan Ortu melihat data pribadi
        elseif (in_array($user->level, ['siswa', 'ortu'])) {
            $widgets = [
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\LatestPelanggaran::class,
            ];
        }

        return $widgets;
    }
}
