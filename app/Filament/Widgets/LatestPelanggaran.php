<?php

namespace App\Filament\Widgets;

use App\Models\Pelanggaran;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class LatestPelanggaran extends BaseWidget
{
    protected static ?int $sort = 10;
    protected int | string | array $columnSpan = 'full';
    
    protected function getTableHeading(): string
    {
        return 'Daftar Pelanggaran Terakhir';
    }

    public function table(Table $table): Table
    {
        $user = Auth::user();
        $query = Pelanggaran::query()->latest()->limit(5);
        
        // Filter berdasarkan role (seperti di arsip_lama)
        if ($user && in_array($user->level, ['guru', 'walikelas'])) {
            $query->where('guru_pencatat', $user->guru_id);
        } elseif ($user && $user->level === 'siswa') {
            $query->where('siswa_id', $user->siswa?->id);
        } elseif ($user && $user->level === 'ortu') {
            $siswaId = $user->orangtua->first()?->siswa_id;
            if ($siswaId) {
                $query->where('siswa_id', $siswaId);
            } else {
                $query->whereRaw('1=0'); // No child found
            }
        }

        return $table
            ->query($query)
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i'),
                TextColumn::make('siswa.nama_siswa')
                    ->label('Siswa'),
                TextColumn::make('siswa.kelas.nama_kelas')
                    ->label('Kelas'),
                TextColumn::make('jenisPelanggaran.nama_pelanggaran')
                    ->label('Pelanggaran'),
                TextColumn::make('poin')
                    ->badge()
                    ->color('danger'),
            ]);
    }
}
