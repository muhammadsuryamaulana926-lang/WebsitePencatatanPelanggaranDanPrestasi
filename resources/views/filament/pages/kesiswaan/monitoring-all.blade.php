<x-filament-panels::page>
    <div class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Total Pelanggar</p>
                <p class="text-2xl font-black text-danger-600">{{ \App\Models\Siswa::whereHas('pelanggaran')->count() }}</p>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Poin Tertinggi</p>
                <p class="text-2xl font-black text-warning-600">{{ \App\Models\Pelanggaran::groupBy('siswa_id')->selectRaw('sum(poin) as total')->orderBy('total','desc')->first()?->total ?? 0 }}</p>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Rata-rata Poin</p>
                @php
                    $totalSiswa = \App\Models\Siswa::count();
                    $totalPoin = \App\Models\Pelanggaran::sum('poin');
                    $avg = $totalSiswa > 0 ? round($totalPoin / $totalSiswa, 1) : 0;
                @endphp
                <p class="text-2xl font-black text-primary-600">{{ $avg }}</p>
            </div>
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page>
