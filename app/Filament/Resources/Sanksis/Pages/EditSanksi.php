<?php

namespace App\Filament\Resources\Sanksis\Pages;

use App\Filament\Resources\Sanksis\SanksiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSanksi extends EditRecord
{
    protected static string $resource = SanksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
