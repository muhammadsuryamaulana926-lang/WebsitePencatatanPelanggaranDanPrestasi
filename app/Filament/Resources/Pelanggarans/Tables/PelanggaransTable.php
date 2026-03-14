<?php

namespace App\Filament\Resources\Pelanggarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PelanggaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('siswa.nama_siswa')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('guruPencatat.nama_guru')
                    ->label('Guru Pencatat')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jenisPelanggaran.nama_pelanggaran')
                    ->label('Jenis Pelanggaran')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tahunAjaran.tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->sortable(),
                TextColumn::make('poin')
                    ->label('Poin')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Input')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                \App\Filament\Actions\ExportPdfAction::make('reports.pelanggaran', [
                    'records' => \App\Models\Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])->get()
                ])->label('Export PDF (Semua)'),
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
