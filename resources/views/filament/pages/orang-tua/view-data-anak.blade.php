<x-filament-panels::page>
    <div class="space-y-6">
        @php $siswa = $this->getSiswa(); @endphp
        
        @if($siswa)
            <div class="bg-primary-50 p-4 rounded-xl border border-primary-100 dark:bg-primary-900/10 dark:border-primary-500/20">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary-100 rounded-full dark:bg-primary-800">
                        <x-heroicon-o-user class="w-6 h-6 text-primary-600 dark:text-primary-400" />
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-primary-900 dark:text-primary-100">{{ $siswa->nama_siswa }}</h2>
                        <p class="text-sm text-primary-600 dark:text-primary-400">NIS: {{ $siswa->nis }} | Kelas: {{ $siswa->kelas?->nama_kelas ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-danger-500" />
                    Pelanggaran Anak
                </h3>
                {{ $this->table }}
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <x-heroicon-o-trophy class="w-5 h-5 text-success-500" />
                    Prestasi Anak
                </h3>
                {{ $this->getPrestasiTable() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500">Data anak tidak ditemukan atau akun Anda belum terhubung dengan data siswa.</p>
            </div>
        @endif
    </div>
</x-filament-panels::page>