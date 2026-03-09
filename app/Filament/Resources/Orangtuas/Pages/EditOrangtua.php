<?php

namespace App\Filament\Resources\Orangtuas\Pages;

use App\Filament\Resources\Orangtuas\OrangtuaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrangtua extends EditRecord
{
    protected static string $resource = OrangtuaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
