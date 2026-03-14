<?php

namespace App\Filament\Pages\OrangTua;

use Illuminate\Support\Facades\Auth;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Siswa;

class ViewDataAnak extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.orang-tua.view-data-anak';
    protected static ?string $navigationLabel = 'Data Anak';
    protected static ?string $title = 'Data Pelanggaran & Prestasi Anak';
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-user-group';
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'ortu';
    }

    public function table(Table $table): Table
    {
        $user = Auth::user();
        $siswaId = $user->orangtua->first()?->siswa_id;

        return $table
            ->query(
                Pelanggaran::query()
                    ->where('siswa_id', $siswaId)
                    ->with(['jenisPelanggaran', 'guruPencatat'])
            )
            ->columns([
                TextColumn::make('jenisPelanggaran.nama_pelanggaran')->label('Jenis Pelanggaran'),
                TextColumn::make('poin')->label('Poin')->badge()->color('danger'),
                TextColumn::make('keterangan')->label('Keterangan')->limit(30),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d/m/Y'),
            ])
            ->emptyStateHeading('Tidak ada data pelanggaran');
    }

    public function getPrestasiTable(): Table
    {
        $user = Auth::user();
        $siswaId = $user->orangtua->first()?->siswa_id;

        return Table::make($this)
            ->query(
                Prestasi::query()
                    ->where('siswa_id', $siswaId)
                    ->with(['jenisPrestasi', 'guruPencatat'])
            )
            ->columns([
                TextColumn::make('jenisPrestasi.nama_prestasi')->label('Jenis Prestasi'),
                TextColumn::make('poin')->label('Poin')->badge()->color('success'),
                TextColumn::make('keterangan')->label('Keterangan')->limit(30),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d/m/Y'),
            ])
            ->emptyStateHeading('Tidak ada data prestasi');
    }

    public function getSiswa(): ?Siswa
    {
        return Auth::user()->orangtua->first()?->siswa;
    }
}