<x-filament-panels::page>
    <div class="space-y-6">
        <div>
            <h3 class="text-lg font-semibold mb-4">Pelanggaran Saya</h3>
            {{ $this->table }}
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-4">Prestasi Saya</h3>
            {{ $this->getPrestasiTable() }}
        </div>
    </div>
</x-filament-panels::page>
