<?php

namespace App\Filament\Resources\PelaksanaanSanksis\Pages;

use App\Filament\Resources\PelaksanaanSanksis\PelaksanaanSanksiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPelaksanaanSanksis extends ListRecords
{
    protected static string $resource = PelaksanaanSanksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
