<?php

namespace App\Filament\Resources\Orangtuas\Pages;

use App\Filament\Resources\Orangtuas\OrangtuaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrangtuas extends ListRecords
{
    protected static string $resource = OrangtuaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
