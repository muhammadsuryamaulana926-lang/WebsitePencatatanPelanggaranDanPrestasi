<?php

namespace App\Filament\Resources\VerifikasiData\Pages;

use App\Filament\Resources\VerifikasiData\VerifikasiDataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVerifikasiData extends ListRecords
{
    protected static string $resource = VerifikasiDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
