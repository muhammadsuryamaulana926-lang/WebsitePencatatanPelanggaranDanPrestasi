<?php

namespace App\Filament\Pages\WaliKelas;

use App\Models\Siswa;
use App\Models\Pelanggaran;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;

class DataKelas extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static ?string $navigationLabel = 'Data Kelas Wali';
    protected static ?string $title = 'Data Kelas Wali';
    protected static string|UnitEnum|null $navigationGroup = 'Layanan Kesiswaan';
    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.wali-kelas.data-kelas';

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'walikelas';
    }

    public function table(Table $table): Table
    {
        $guruId = Auth::user()->guru_id;
        
        return $table
            ->query(
                Siswa::query()
                    ->whereHas('kelas', fn($q) => $q->where('wali_kelas', $guruId))
                    ->with(['kelas', 'pelanggaran'])
                    ->withSum('pelanggaran as total_poin', 'poin')
            )
            ->columns([
                TextColumn::make('nama_siswa')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_poin')
                    ->label('Total Poin Pelanggaran')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 90 => 'danger',
                        $state >= 41 => 'warning',
                        default => 'info',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->state(fn (Siswa $record): string => match (true) {
                        $record->total_poin >= 90 => 'Kritis',
                        $record->total_poin >= 41 => 'Waspada',
                        $record->total_poin > 0 => 'Pantauan',
                        default => 'Aman',
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Kritis' => 'danger',
                        'Waspada' => 'warning',
                        'Pantauan' => 'info',
                        default => 'success',
                    }),
            ])
            ->defaultSort('total_poin', 'desc');
    }
}
