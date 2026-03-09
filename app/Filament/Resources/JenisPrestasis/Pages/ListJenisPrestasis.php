<?php

namespace App\Filament\Resources\JenisPrestasis\Pages;

use App\Filament\Resources\JenisPrestasis\JenisPrestasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJenisPrestasis extends ListRecords
{
    protected static string $resource = JenisPrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
