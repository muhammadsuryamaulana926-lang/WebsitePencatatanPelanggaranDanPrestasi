<?php

namespace App\Filament\Resources\BimbinganKonselings\Pages;

use App\Filament\Resources\BimbinganKonselings\BimbinganKonselingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBimbinganKonselings extends ListRecords
{
    protected static string $resource = BimbinganKonselingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
