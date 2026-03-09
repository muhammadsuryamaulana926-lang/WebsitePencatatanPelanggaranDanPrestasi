<?php

namespace App\Filament\Resources\JenisPrestasis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JenisPrestasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_prestasi')
                    ->required(),
                TextInput::make('poin')
                    ->required()
                    ->numeric(),
                Select::make('kategori')
                    ->options([
            'akademik' => 'Akademik',
            'non_akademik' => 'Non akademik',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
        ])
                    ->required(),
                TextInput::make('deskripsi'),
            ]);
    }
}
