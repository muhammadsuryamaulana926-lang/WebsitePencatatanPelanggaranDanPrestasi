<?php

namespace App\Filament\Resources\JenisPrestasis\Pages;

use App\Filament\Resources\JenisPrestasis\JenisPrestasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJenisPrestasi extends EditRecord
{
    protected static string $resource = JenisPrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
