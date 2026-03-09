<?php

namespace App\Filament\Resources\VerifikasiData\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VerifikasiDataForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tabel_terkait')
                    ->required(),
                TextInput::make('id_terkait')
                    ->required()
                    ->numeric(),
                TextInput::make('guru_verifikator')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options([
            'menunggu' => 'Menunggu',
            'diverifikasi' => 'Diverifikasi',
            'ditolak' => 'Ditolak',
            'revisi' => 'Revisi',
        ])
                    ->default('menunggu'),
                Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }
}
