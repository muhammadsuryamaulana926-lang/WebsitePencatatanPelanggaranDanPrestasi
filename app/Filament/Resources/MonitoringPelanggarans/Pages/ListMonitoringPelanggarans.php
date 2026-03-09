<?php

namespace App\Filament\Resources\MonitoringPelanggarans\Pages;

use App\Filament\Resources\MonitoringPelanggarans\MonitoringPelanggaranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMonitoringPelanggarans extends ListRecords
{
    protected static string $resource = MonitoringPelanggaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
