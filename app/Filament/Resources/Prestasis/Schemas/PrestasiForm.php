<?php

namespace App\Filament\Resources\Prestasis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PrestasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('siswa_id')
                    ->required()
                    ->numeric(),
                TextInput::make('guru_pencatat')
                    ->numeric(),
                TextInput::make('jenis_prestasi_id')
                    ->required()
                    ->numeric(),
                TextInput::make('tahun_ajaran_id')
                    ->required()
                    ->numeric(),
                TextInput::make('poin')
                    ->required()
                    ->numeric(),
                Textarea::make('keterangan')
                    ->columnSpanFull(),
                Select::make('status_verifikasi')
                    ->options(['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'])
                    ->default('menunggu')
                    ->required(),
            ]);
    }
}
