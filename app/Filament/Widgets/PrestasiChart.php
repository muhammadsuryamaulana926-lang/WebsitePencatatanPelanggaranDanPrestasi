<?php

namespace App\Filament\Widgets;

use App\Models\Prestasi;
use App\Models\JenisPrestasi;
use Filament\Widgets\ChartWidget;

class PrestasiChart extends ChartWidget
{
    protected ?string $heading = 'Prestasi per Jenis';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 1;

    public static function canView(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    protected function getData(): array
    {
        $jenisList = JenisPrestasi::withCount('prestasi')->get();

        $labels = $jenisList->pluck('nama_prestasi')->toArray();
        $counts = $jenisList->pluck('prestasi_count')->toArray();

        $colors = [
            'rgba(245, 158, 11, 0.7)',
            'rgba(16, 185, 129, 0.7)',
            'rgba(59, 130, 246, 0.7)',
            'rgba(139, 92, 246, 0.7)',
            'rgba(239, 68, 68, 0.7)',
            'rgba(236, 72, 153, 0.7)',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Prestasi',
                    'data' => $counts,
                    'backgroundColor' => array_slice($colors, 0, count($labels)),
                    'borderColor' => '#fff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
