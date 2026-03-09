<?php

namespace App\Filament\Resources\Sanksis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SanksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pelanggaran_id')
                    ->required()
                    ->numeric(),
                TextInput::make('jenis_sanksi')
                    ->required(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
                DatePicker::make('tanggal_mulai'),
                DatePicker::make('tanggal_selesai'),
                Select::make('status')
                    ->options([
            'direncanakan' => 'Direncanakan',
            'berjalan' => 'Berjalan',
            'selesai' => 'Selesai',
            'ditunda' => 'Ditunda',
            'dibatalkan' => 'Dibatalkan',
        ])
                    ->default('direncanakan'),
            ]);
    }
}
