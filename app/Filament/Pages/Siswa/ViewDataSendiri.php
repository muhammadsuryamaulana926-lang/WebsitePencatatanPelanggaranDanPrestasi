<?php

namespace App\Filament\Pages\Siswa;

use Illuminate\Support\Facades\Auth;

use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\Pelanggaran;
use App\Models\Prestasi;

class ViewDataSendiri extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.siswa.view-data-sendiri';
    protected static ?string $navigationLabel = 'Data Saya';
    protected static ?string $title = 'Data Pelanggaran & Prestasi Saya';
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-user';
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'siswa' && $user->siswa;
    }

    public function table(Table $table): Table
    {
        $siswaId = Auth::user()->siswa?->id;

        return $table
            ->query(
                Pelanggaran::query()
                    ->where('siswa_id', $siswaId)
                    ->with(['jenisPelanggaran', 'guruPencatat'])
            )
            ->columns([
                TextColumn::make('jenisPelanggaran.nama_pelanggaran')->label('Jenis Pelanggaran'),
                TextColumn::make('poin')->label('Poin')->badge()->color('danger'),
                TextColumn::make('guruPencatat.nama_guru')->label('Dicatat Oleh'),
                TextColumn::make('keterangan')->label('Keterangan')->limit(30),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d/m/Y'),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public function getPrestasiTable(): Table
    {
        $siswaId = Auth::user()->siswa?->id;

        return Table::make()
            ->query(
                Prestasi::query()
                    ->where('siswa_id', $siswaId)
                    ->with(['jenisPrestasi', 'guruPencatat'])
            )
            ->columns([
                TextColumn::make('jenisPrestasi.nama_prestasi')->label('Jenis Prestasi'),
                TextColumn::make('poin')->label('Poin')->badge()->color('success'),
                TextColumn::make('guruPencatat.nama_guru')->label('Dicatat Oleh'),
                TextColumn::make('keterangan')->label('Keterangan')->limit(30),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d/m/Y'),
            ]);
    }
}
