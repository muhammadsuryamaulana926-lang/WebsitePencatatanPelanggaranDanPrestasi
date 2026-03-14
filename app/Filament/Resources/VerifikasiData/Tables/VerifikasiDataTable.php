<?php

namespace App\Filament\Resources\VerifikasiData\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VerifikasiDataTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tabel_terkait')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pelanggaran' => 'danger',
                        'prestasi' => 'success',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('siswa_nama')
                    ->label('Siswa')
                    ->state(fn ($record) => $record->siswa?->nama_siswa ?? '-')
                    ->searchable(),
                TextColumn::make('jenis_data')
                    ->label('Detail Data')
                    ->state(fn ($record) => $record->jenis_data),
                TextColumn::make('guru.nama_guru')
                    ->label('Verifikator')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'menunggu' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
