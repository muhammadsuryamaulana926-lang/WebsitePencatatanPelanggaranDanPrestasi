<?php

namespace App\Filament\Resources\TahunAjarans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TahunAjaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tahun_ajaran')
                    ->required(),
                Select::make('semester')
                    ->options(['Ganjil' => 'Ganjil', 'Genap' => 'Genap'])
                    ->required(),
                Toggle::make('status_aktif')
                    ->required(),
            ]);
    }
}
