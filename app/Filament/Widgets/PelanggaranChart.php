<?php

namespace App\Filament\Widgets;

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
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'kepalasekolah']);
    }

    protected function getData(): array
    {
        $months = [];
        $counts = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');
            $counts[] = Pelanggaran::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
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
