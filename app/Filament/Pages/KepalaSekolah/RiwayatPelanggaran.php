<?php

namespace App\Filament\Pages\KepalaSekolah;

use App\Models\Pelanggaran;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;

class RiwayatPelanggaran extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|UnitEnum|null $navigationGroup = 'Monitoring & Verifikasi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;
    protected static ?string $navigationLabel = 'Riwayat Pelanggaran';
    protected static ?string $title = 'Riwayat Pelanggaran';
    protected static ?int $navigationSort = 23;
    protected string $view = 'filament.pages.kepala-sekolah.riwayat-pelanggaran';

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-clock';
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'kepalasekolah']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Pelanggaran::query()->latest())
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('siswa.nama_siswa')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('siswa.kelas.nama_kelas')
                    ->label('Kelas')
                    ->sortable(),
                TextColumn::make('jenisPelanggaran.nama_pelanggaran')
                    ->label('Pelanggaran')
                    ->sortable(),
                TextColumn::make('poin')
                    ->label('Poin')
                    ->badge()
                    ->color('danger'),
                TextColumn::make('guruPencatat.nama_guru')
                    ->label('Pencatat')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('kelas_id')
                    ->relationship('siswa.kelas', 'nama_kelas')
                    ->label('Filter Kelas'),
            ]);
    }
}