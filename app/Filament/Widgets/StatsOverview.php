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
    
    public static function canView(): bool
    {
        return auth()->check();
    }
    
    protected function getStats(): array
    {
        $user = auth()->user();
        
        if (!$user) {
            return [];
        }

        $stats = [];

        // Admin dan Kesiswaan melihat semua statistik
        if (in_array($user->level, ['admin', 'kesiswaan', 'kepalasekolah'])) {
            $stats = [
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
        // Guru melihat statistik data yang dicatat sendiri
        elseif ($user->level === 'guru' && $user->guru_id) {
            $stats = [
                Stat::make('Pelanggaran Saya', Pelanggaran::where('guru_pencatat', $user->guru_id)->count())
                    ->description('Yang saya catat')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('warning'),
            ];
        }
        // Wali Kelas melihat statistik kelas wali
        elseif ($user->level === 'walikelas' && $user->guru_id) {
            $kelasWali = \App\Models\Kelas::where('wali_kelas', $user->guru_id)->pluck('id');
            $siswaKelas = Siswa::whereIn('kelas_id', $kelasWali)->pluck('id');
            
            $stats = [
                Stat::make('Siswa Kelas Wali', Siswa::whereIn('kelas_id', $kelasWali)->count())
                    ->description('Total siswa')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('primary'),
                Stat::make('Pelanggaran Kelas', Pelanggaran::whereIn('siswa_id', $siswaKelas)->count())
                    ->description('Pelanggaran kelas wali')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('danger'),
            ];
        }
        // BK melihat statistik bimbingan konseling
        elseif ($user->level === 'bk' && $user->guru_id) {
            $stats = [
                Stat::make('Bimbingan Konseling', \App\Models\BimbinganKonseling::where('guru_konselor', $user->guru_id)->count())
                    ->description('Total bimbingan')
                    ->descriptionIcon('heroicon-m-heart')
                    ->color('info'),
            ];
        }
        // Siswa melihat data pribadi
        elseif ($user->level === 'siswa') {
            $siswa = $user->siswa;
            if ($siswa) {
                $stats = [
                    Stat::make('Pelanggaran Saya', Pelanggaran::where('siswa_id', $siswa->id)->count())
                        ->description('Total pelanggaran')
                        ->descriptionIcon('heroicon-m-exclamation-triangle')
                        ->color('danger'),
                    Stat::make('Prestasi Saya', Prestasi::where('siswa_id', $siswa->id)->count())
                        ->description('Total prestasi')
                        ->descriptionIcon('heroicon-m-trophy')
                        ->color('success'),
                ];
            }
        }
        // Orang Tua melihat data anak
        elseif ($user->level === 'ortu') {
            $orangtua = $user->orangtua->first();
            if ($orangtua && $orangtua->siswa_id) {
                $stats = [
                    Stat::make('Pelanggaran Anak', Pelanggaran::where('siswa_id', $orangtua->siswa_id)->count())
                        ->description('Total pelanggaran')
                        ->descriptionIcon('heroicon-m-exclamation-triangle')
                        ->color('danger'),
                    Stat::make('Prestasi Anak', Prestasi::where('siswa_id', $orangtua->siswa_id)->count())
                        ->description('Total prestasi')
                        ->descriptionIcon('heroicon-m-trophy')
                        ->color('success'),
                ];
            }
        }

        return $stats;
    }
}
