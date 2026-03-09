<?php

namespace App\Filament\Resources\PelaksanaanSanksis\Pages;

use App\Filament\Resources\PelaksanaanSanksis\PelaksanaanSanksiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPelaksanaanSanksi extends EditRecord
{
    protected static string $resource = PelaksanaanSanksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
