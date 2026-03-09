<?php

namespace App\Filament\Widgets;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Siswa', Siswa::count())
                ->description('Siswa terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Pelanggaran', Pelanggaran::count())
                ->description('Total insiden tercatat')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
            Stat::make('Prestasi', Prestasi::count())
                ->description('Pencapaian siswa')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('success'),
        ];
    }
}
