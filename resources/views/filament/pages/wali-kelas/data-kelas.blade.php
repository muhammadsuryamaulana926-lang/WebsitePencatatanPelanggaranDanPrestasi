<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
            <h2 class="text-xl font-bold mb-2">Monitoring Siswa Kelas Anda</h2>
            <p class="text-gray-500">Daftar siswa dan akumulasi poin pelanggaran untuk kelas yang Anda bimbing.</p>
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page>
