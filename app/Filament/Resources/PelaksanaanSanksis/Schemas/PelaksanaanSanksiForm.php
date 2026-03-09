<?php

namespace App\Filament\Resources\PelaksanaanSanksis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PelaksanaanSanksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sanksi_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('tanggal_pelaksanaan')
                    ->required(),
                TextInput::make('bukti'),
                Textarea::make('catatan')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
            'terjadwal' => 'Terjadwal',
            'dikerjakan' => 'Dikerjakan',
            'tuntas' => 'Tuntas',
            'terlambat' => 'Terlambat',
            'perpanjangan' => 'Perpanjangan',
        ])
                    ->default('terjadwal')
                    ->required(),
            ]);
    }
}
