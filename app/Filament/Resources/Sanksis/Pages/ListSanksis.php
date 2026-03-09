<?php

namespace App\Filament\Resources\Sanksis\Pages;

use App\Filament\Resources\Sanksis\SanksiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSanksis extends ListRecords
{
    protected static string $resource = SanksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
