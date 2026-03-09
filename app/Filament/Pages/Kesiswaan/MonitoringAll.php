<?php

namespace App\Filament\Pages\Kesiswaan;

use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\Siswa;

class MonitoringAll extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.kesiswaan.monitoring-all';
    protected static ?string $navigationLabel = 'Monitoring All';
    protected static ?string $title = 'Monitoring Semua Siswa';
    public static function getNavigationGroup(): ?string
    {
        return 'Monitoring & Verifikasi';
    }
    protected static ?int $navigationSort = 41;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-eye';
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['kesiswaan', 'kepalasekolah']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Siswa::query()
                    ->with(['kelas', 'pelanggaran.jenisPelanggaran', 'prestasi.jenisPrestasi'])
                    ->withCount(['pelanggaran', 'prestasi'])
            )
            ->columns([
                TextColumn::make('nis')->label('NIS')->searchable(),
                TextColumn::make('nama_siswa')->label('Nama Siswa')->searchable(),
                TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                TextColumn::make('pelanggaran_count')->label('Total Pelanggaran')->badge()->color('danger'),
                TextColumn::make('prestasi_count')->label('Total Prestasi')->badge()->color('success'),
                TextColumn::make('total_poin')
                    ->label('Total Poin Pelanggaran')
                    ->getStateUsing(fn ($record) => $record->pelanggaran->sum('poin'))
                    ->badge()
                    ->color(fn ($state) => $state >= 100 ? 'danger' : ($state >= 50 ? 'warning' : 'success')),
            ])
            ->defaultSort('pelanggaran_count', 'desc')
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }
}
