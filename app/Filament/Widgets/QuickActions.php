<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class QuickActions extends Widget
{
    protected string $view = 'filament.widgets.quick-actions';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['guru', 'walikelas', 'kesiswaan', 'bk', 'admin']);
    }

    public function getActions(): array
    {
        $user = Auth::user();
        $actions = [];

        if (in_array($user->level, ['guru', 'walikelas', 'admin'])) {
            $actions[] = [
                'label' => 'Input Pelanggaran Baru',
                'url' => '/admin/input-pelanggaran',
                'icon' => 'heroicon-o-plus-circle',
                'color' => 'success',
                'description' => 'Mencatat pelanggaran siswa baru'
            ];
        }

        if (in_array($user->level, ['guru', 'walikelas'])) {
            $actions[] = [
                'label' => 'Lihat Data Saya',
                'url' => '/admin/view-data-sendiri',
                'icon' => 'heroicon-o-user',
                'color' => 'primary',
                'description' => 'Melihat riwayat pencatatan saya'
            ];
        }

        if ($user->level === 'walikelas') {
            $actions[] = [
                'label' => 'Monitoring Kelas',
                'url' => '/admin/data-kelas',
                'icon' => 'heroicon-o-academic-cap',
                'color' => 'warning',
                'description' => 'Pantau poin siswa se-kelas'
            ];
        }

        if (in_array($user->level, ['kesiswaan', 'admin'])) {
            $actions[] = [
                'label' => 'Verifikasi Data',
                'url' => '/admin/verifikasi-data',
                'icon' => 'heroicon-o-check-badge',
                'color' => 'danger',
                'description' => 'Menyetujui input pelanggaran/prestasi'
            ];
        }

        if (in_array($user->level, ['bk', 'admin'])) {
            $actions[] = [
                'label' => 'Input BK',
                'url' => '/admin/input-bk',
                'icon' => 'heroicon-o-heart',
                'color' => 'info',
                'description' => 'Mencatat sesi bimbingan konseling'
            ];
        }

        return $actions;
    }
}
