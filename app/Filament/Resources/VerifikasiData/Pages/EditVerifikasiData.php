<?php

namespace App\Filament\Resources\VerifikasiData\Pages;

use App\Filament\Resources\VerifikasiData\VerifikasiDataResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVerifikasiData extends EditRecord
{
    protected static string $resource = VerifikasiDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
