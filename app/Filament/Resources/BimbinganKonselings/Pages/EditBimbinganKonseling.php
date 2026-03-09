<?php

namespace App\Filament\Resources\BimbinganKonselings\Pages;

use App\Filament\Resources\BimbinganKonselings\BimbinganKonselingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBimbinganKonseling extends EditRecord
{
    protected static string $resource = BimbinganKonselingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
