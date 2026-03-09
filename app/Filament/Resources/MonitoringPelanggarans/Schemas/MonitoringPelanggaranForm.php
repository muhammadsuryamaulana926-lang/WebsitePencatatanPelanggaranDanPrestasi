<?php

namespace App\Filament\Resources\MonitoringPelanggarans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MonitoringPelanggaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pelanggaran_id')
                    ->required()
                    ->numeric(),
                TextInput::make('guru_kepsek')
                    ->numeric(),
                Textarea::make('catatan')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(['dipantau' => 'Dipantau', 'dalam_tindakan' => 'Dalam tindakan', 'selesai' => 'Selesai'])
                    ->default('dipantau')
                    ->required(),
            ]);
    }
}
