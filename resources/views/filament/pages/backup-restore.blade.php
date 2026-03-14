<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-arrow-down-tray" class="h-5 w-5 text-success-500" />
                    <span>Informasi Backup</span>
                </div>
            </x-slot>
            
            <p class="text-sm text-gray-500 mb-4">
                Lakukan backup secara berkala untuk menjaga keamanan data sekolah.
            </p>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h4 class="font-medium text-gray-900 mb-2 text-sm">Jadwal Otomatis:</h4>
                <ul class="text-xs text-gray-600 space-y-1">
                    <li>• Daily incremental backup (00:00)</li>
                    <li>• Weekly full backup (Minggu 02:00)</li>
                    <li>• Monthly archive backup (Akhir bulan)</li>
                </ul>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-arrow-up-tray" class="h-5 w-5 text-warning-500" />
                    <span>Restore Data</span>
                </div>
            </x-slot>

            <p class="text-sm text-gray-500 mb-4">
                Pilih file backup untuk mengembalikan data ke titik sebelumnya.
            </p>

            <form wire:submit="restore" class="space-y-4">
                <input type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" />
                
                <x-filament::button color="warning" class="w-full">
                    Mulai Restore
                </x-filament::button>
            </form>
        </x-filament::section>
    </div>

    <x-filament::section class="mt-6">
        <x-slot name="heading">
            Daftar File Backup
        </x-slot>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="py-3 px-4 font-medium">Nama File</th>
                        <th class="py-3 px-4 font-medium">Ukuran</th>
                        <th class="py-3 px-4 font-medium">Tanggal</th>
                        <th class="py-3 px-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->getBackups() as $backup)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $backup['name'] }}</td>
                        <td class="py-3 px-4">{{ $backup['size'] }}</td>
                        <td class="py-3 px-4">{{ $backup['date'] }}</td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex justify-end gap-2">
                                <x-filament::icon-button icon="heroicon-o-arrow-down-tray" color="info" tooltip="Download" />
                                <x-filament::icon-button icon="heroicon-o-trash" color="danger" tooltip="Hapus" />
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
