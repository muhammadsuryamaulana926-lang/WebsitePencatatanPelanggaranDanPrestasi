<?php

namespace App\Filament\Resources\Pelanggarans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PelanggaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('siswa_id')
                    ->relationship('siswa', 'nama_siswa')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('guru_pencatat')
                    ->relationship('guru', 'nama_guru')
                    ->searchable()
                    ->preload()
                    ->label('Guru Pencatat'),
                Select::make('jenis_pelanggaran_id')
                    ->relationship('jenisPelanggaran', 'nama_pelanggaran')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, $set) => $set('poin', \App\Models\JenisPelanggaran::find($state)?->poin ?? 0)),
                Select::make('tahun_ajaran_id')
                    ->relationship('tahunAjaran', 'tahun_ajaran')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('poin')
                    ->required()
                    ->numeric()
                    ->helperText('Poin akan terisi otomatis berdasarkan jenis pelanggaran'),
                Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }
}
