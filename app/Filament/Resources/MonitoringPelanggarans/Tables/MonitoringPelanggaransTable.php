<?php

namespace App\Filament\Resources\MonitoringPelanggarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MonitoringPelanggaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pelanggaran.siswa.nama_siswa')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pelanggaran.jenisPelanggaran.nama_pelanggaran')
                    ->label('Pelanggaran')
                    ->sortable(),
                TextColumn::make('guruKepsek.nama_guru')
                    ->label('Guru/Kepsek Pemantau')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'dipantau' => 'warning',
                        'dalam_tindakan' => 'info',
                        'selesai' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('updated_at')
                    ->label('Update Terakhir')
                    ->dateTime('d/m/Y H:i')
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
