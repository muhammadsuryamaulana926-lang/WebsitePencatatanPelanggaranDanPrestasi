<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\Auth;

use App\Models\Pelanggaran;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class PelanggaranChart extends ChartWidget
{
    protected ?string $heading = 'Pelanggaran per Bulan (Tahun Ini)';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 1;

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'kepalasekolah', 'guru', 'walikelas']);
    }

    protected function getData(): array
    {
        $user = Auth::user();
        $months = [];
        $counts = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');
            
            $query = Pelanggaran::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);
            
            if (in_array($user->level, ['guru', 'walikelas'])) {
                $query->where('guru_pencatat', $user->guru_id);
            }

            $counts[] = $query->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pelanggaran',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                    'borderColor' => 'rgb(239, 68, 68)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
