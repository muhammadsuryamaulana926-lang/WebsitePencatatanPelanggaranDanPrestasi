<?php

namespace App\Filament\Resources\JenisPelanggarans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class JenisPelanggaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_pelanggaran')
                    ->required(),
                TextInput::make('poin')
                    ->required()
                    ->numeric(),
                Select::make('kategori')
                    ->options([
            'ringan' => 'Ringan',
            'sedang' => 'Sedang',
            'berat' => 'Berat',
            'sangat_berat' => 'Sangat berat',
        ]),
                TextInput::make('kategori_utama')
                    ->required(),
                Textarea::make('sanksi_rekomendasi')
                    ->columnSpanFull(),
            ]);
    }
}
