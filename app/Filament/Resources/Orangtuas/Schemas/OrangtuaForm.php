<?php

namespace App\Filament\Resources\Orangtuas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrangtuaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('siswa_id')
                    ->required()
                    ->numeric(),
                Select::make('hubungan')
                    ->options(['ayah' => 'Ayah', 'ibu' => 'Ibu', 'wali' => 'Wali'])
                    ->required(),
                TextInput::make('nama_orangtua')
                    ->required(),
                TextInput::make('pekerjaan'),
                TextInput::make('pendidikan'),
                TextInput::make('no_telp')
                    ->tel(),
                Textarea::make('alamat')
                    ->columnSpanFull(),
            ]);
    }
}
