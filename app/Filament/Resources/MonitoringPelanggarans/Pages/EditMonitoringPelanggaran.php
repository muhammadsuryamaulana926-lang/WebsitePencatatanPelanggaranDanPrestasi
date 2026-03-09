<?php

namespace App\Filament\Resources\MonitoringPelanggarans\Pages;

use App\Filament\Resources\MonitoringPelanggarans\MonitoringPelanggaranResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMonitoringPelanggaran extends EditRecord
{
    protected static string $resource = MonitoringPelanggaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
